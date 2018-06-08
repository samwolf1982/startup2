<?php
class ModelToolAncestorfield extends Model {
    private  $colections_inputs;


    /**
     * обычное текстовое поле в таблице
     * @param $name    name, array like         boby[]
     * @param string $default_val
     * @param string $class     class for td
     * @return string
     */
    public function get_text_input($name, $default_val='',$class='left'){


        return  "<td class='".$class."'> <input type='text' name='".  $name .  "' value='".$default_val."' class='form-control'></td>";

    }


    /**
     * @param $name
     * @param $data    состоит из  [ [value=>x,name=>x],]      exapmle:  [ [2,'text1'],[4,'text5'],[8,123] ]
      * @param $selected        // value                       example                  4
     * @param string $class
     * @param string $default_val
     * @return string
     */
    public function get_select_input($name, $data, $selected='', $class='left', $default_val=''){
        $res=  "<td class='".$class."'><select name='".$name."'  class='form-control'>";

        foreach ($data as $item) {
            $sel='';
            if ($item[0]==$selected){
                $sel= "selected='selected'";
            }
            $res.="<option value='".$item[0]."'  ".$sel.">".$item[1]."</option>";
         }
         $res.="</select> </td>";
 return $res;
//        <select name="account_status" id="input-status" class="form-control">
//<option value="1" selected="selected">Включено</option>
//<option value="0">Отключено</option>
//</select>
    }



    /**
     * финальная сборка из вышепоставленых инпутов в таблице
     *
     * @param $colections_inputs        colections of top inputs
     * @param $id
     * @param string $default_val       ---
     * @return string
     */
    public function get_ancestor($colections_inputs,$id='',  $default_val=''){
        if (empty($id)){
            $res= "<tr>";
        }else{
            $res= "<tr id='".$id."'>";
        }

        foreach ($colections_inputs as $cl) {
                $res.=$cl;
        }
        $res.= "<td class='left'>    <a onclick='$(this).parent().parent().remove();' data-toggle='tooltip' title='Удалить' class='btn btn-danger'><i class='fa fa-minus-circle'></i></a>  </td></tr>";
         return $res;

    }


}