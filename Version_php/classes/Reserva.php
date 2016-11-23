<?php

/**
 * Implementación de la clase Reserva
 */
class Reserva
{
    protected $reserva_id;
    protected $nombre;
    protected $apellido;
    protected $telefono;
    protected $fecha;
    protected $hora;
    protected $cantidad;
    protected $preferenciasElegidas;


    /**
     * Datos de la nueva reserva
     * @var array|null
     */
    protected $vDatos ;


    /**
     * Guarda todos los campos que se envian salvo la foto.
     * @var array
     */
    protected $vCampos ;


    /**
     * Guarda los campos que tienen error, incluyendo la foto.
     * @var array
     */
    protected $vCamposError;


    /**
     * Constructor: si le paso un ID carga los atributos en la instancia.
     * @param null|array $datos
     */
    public function __construct($idReserva = null)
    {
        $this->vDatos= [];
        $this->vCampos = [];
        $this->vCamposError = [];
        if ($idReserva) {
            $this->reserva_id = $idReserva;
            $this->getDetallesReserva();
        };

    }


    /**
     * Carga en memoria los atributos de la instancia en base al ID de la reserva;
     */
    public function getDetallesReserva(){
        $script = "SELECT nombre, apellido, cantidad, telefono, fecha, hora  FROM reservas WHERE reserva_id = ?";
        $stmt = DBConnection::getStatement($script );

        $stmt->execute([$this->reserva_id]);

        if($this->vCampos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->nombre = $this->vCampos['nombre'];
            $this->apellido = $this->vCampos['apellido'];
            $this->cantidad = $this->vCampos['cantidad'];
            $this->telefono = $this->vCampos['telefono'];
            $this->fecha = $this->vCampos['fecha'];
            $this->hora = $this->vCampos['hora'];
            $this->llenarPreferenciasElegidas();
        }
    }

    /**
     * Carga en memoria el atributo preferenciasElegidas de la instancia en base al ID de la reserva;
     */
    protected function llenarPreferenciasElegidas()
    {
        $script = "SELECT p.detalle FROM preferencias  p, reservas_pref r WHERE r.preferencia_id = p.preferencia_id AND r.reserva_id = ? ";
        $stmt = DBConnection::getStatement($script);
        $stmt->execute([$this->reserva_id]);

        if ($stmt->rowCount() > 0) {
            $this->preferenciasElegidas = [];

            while ($filaPreferencia = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->preferenciasElegidas [] = [
                    'detalle' => $filaPreferencia['detalle']
                ];
            }
        }
    }



    /**
     * Devuelve las preferencias existentes a la hora de crear una reserva;
     * @return array of String
     */
    public static function getListadoPreferencias()
    {
        $vPreferencias  = [];
        $script = "SELECT preferencia_id, detalle FROM preferencias ";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute();

        while($filaPreferencia = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vPreferencias [] = [
                'preferencia_id' => $filaPreferencia['preferencia_id'],
                'detalle' => $filaPreferencia['detalle']
            ];
        };
        return $vPreferencias ;
    }




    /**
     * Inserto una nueva reserva en la base de datos;
     * @return int|string
     * @throws ReservaNoGrabadaException
     */
    public function insertarReserva(){
        $vValues = [
            'nombre' => $this->vDatos['nombre'],
            'apellido' => $this->vDatos['apellido'],
            'telefono' => $this->vDatos['telefono'],
            'fecha' => $this->vDatos['fecha'],
            'hora' => $this->vDatos['hora'],
            'cantidad' => $this->vDatos['cantidad'],

        ];
        $reserva_id = 0;
        $script = "INSERT INTO reservas (reserva_id, nombre, apellido, telefono, fecha, hora, cantidad, activa )VALUES (null, :nombre, :apellido, :telefono, :fecha, :hora, :cantidad, '1') ";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($vValues)) {
            $reserva_id  = DBConnection::getConnection()->lastInsertId();
            if ($reserva_id == 0){
                $reserva_id = "error";
            } else {
                if (isset($this->vDatos['preferencia'])){
                    $vPreferencias = $this->vDatos['preferencia'];

                    foreach( $vPreferencias as $i => $preferencia) {
                        $vValues = [
                            'reserva_id' => $reserva_id,
                            'preferencia_id' => $preferencia
                        ];
                        $script = "INSERT INTO reservas_pref (reserva_id, preferencia_id )VALUES (:reserva_id, :preferencia_id) ";
                        $stmt = DBConnection::getStatement($script);
                        if (!$stmt->execute($vValues)){
                            throw new ReservaNoGrabadaException("No se pudo insertar las preferencias de la reserva en la base de datos");
                        };
                    };
                };
            };
        } else {
            throw new ReservaNoGrabadaException("No se pudo insertar la reserva en la base de datos");
        };
        return $reserva_id;
    }


    /**
     * Valida los datos ingresados en el formulario de Reserva;
     */
    public function validar()
    {
        foreach( $this->vDatos as $nombreCampo => $valor) {
            $this->vCampos[$nombreCampo] = $valor;

            $errorActual = $this->validarCampo($nombreCampo, $valor);
            if ($errorActual) {
                $this->vCamposError[$nombreCampo] = $errorActual;
            }
        }
    }



    /**
     * Valida el  valor pasado en $campo en base al $nombre del campo
     * @param $nombre
     * @param $campo
     * @return string
     */
    private function validarCampo($nombre, $campo)
    {
        switch($nombre){
            case 'nombre':
            case 'apellido':
                return $this->validarCampoEspecifico($campo, '/^[a-z\s]+$/i', "El campo solo puede ser texto o espacios");
                break;
            case 'telefono':
                return $this->validarCampoEspecifico($campo, '/^\d{8,}$/', "El campo solo admite números (Mínimo 8)");
                break;
            case 'fecha':
                return $this->validarCampoEspecifico($campo, '/^[012]\d\d\d\-(0?[1-9]|1[0-2])\-([0-9]|[0-2]\d||3[01])$/', "La fecha debe tener formato AAAA-MM-DD");
                break;
            case 'hora':
                return $this->validarCampoEspecifico($campo, '/^([01]\d|2[0123]):[012345]\d$/i', "La hora debe tener formato HH:MM");
                break;
            case 'cantidad':
                return $this->validarCampoEspecifico($campo, '/^\d+$/', "El campo solo admite números");
                break;
            default:
                return "";
        }
    }



    /**
     * Valida que el campo parámetro en base a la expresión del segundo parámetro;
     * Si no es válido devuelve el texto del tercer parámetro o el de requerido cuando corresponda;
     * @param $campo
     * @param $expReg
     * @param $texto
     * @return string
     */
    private function validarCampoEspecifico($campo, $expReg, $texto){
        $valido = preg_match( $expReg, $campo );
        $rta = "";
        if ( !$valido ) {
            if ($campo == "" ){
                $rta = "El campo es requerido";
            }else{
                $rta = $texto;
            }
        }
        return $rta;
    }

    /**
     * @return null
     */
    public function getReservaId()
    {
        return $this->reserva_id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @return mixed
     */
    public function getpreferenciasElegidas()
    {
        return $this->preferenciasElegidas;

    }

    public function eligioPreferencias()
    {
        return isset($this->preferenciasElegidas);
    }

    /**
     * @param array asociativo $datos
     */
    public function setvDatos($datos){
        $this->vDatos= $datos;
    }


    /**
     * @return array|null
     */
    public function getVDatos()
    {
        return $this->vDatos;
    }

    /**
     * @return array
     */
    public function getVCampos()
    {
        return $this->vCampos;
    }

    /**
     * @return array
     */
    public function getVCamposError()
    {
        return $this->vCamposError;
    }




}