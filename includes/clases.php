<?php
class Select{
    private $result;
    public $select;
    private $name;
    private $id;
    private $descripcion;

    public function __construct($result, $name, $id, $descripcion, $select = "")
    {
        $this->result = $result;
        $this->name = $name;
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->select = $select;
        $this->pintar();
    }

    public function pintar()
    {
        $this->result->data_seek(0);
        echo '<select name="'.$this->name.'" id="'.$this->id.'"><option value="">'.$this->descripcion.'</option>';    
            while($row = $this->result->fetch_row()){
                $seleccionado = "";
                if($row[0] == $this->select){
                    $seleccionado = "selected";
                }
                echo '<option '.$seleccionado.' value="'.$row[0].'">'.$row[1].'</option>';
            }
        echo '</select>';
    }
}