 <?php

class fieldtype_custom_button
{
    public $options;
    
    function __construct()
    {
        $this->options = array('title' => "Tombol Custom Lintar");
    }
    
    function get_configuration($params = array())
    {
        $cfg = array();
        $cfg[] = array('title' => "Pilih Entities",
            'name' => 'entity_id',
            'tooltip' => TEXT_FIELDTYPE_ENTITY_SELECT_ENTITY_TOOLTIP,
            'type' => 'dropdown',
            'choices' => entities::get_choices(),
            'params' => array('class' => 'form-control input-medium','onChange' => 'fields_types_ajax_configuration(\'fields_for_search_box\',this.value)'));
    
        $cfg[] = array('name' => 'fields_for_search_box', 'type' => 'ajax', 'html' => '<script>fields_types_ajax_configuration(\'fields_for_search_box\',$("#fields_configuration_entity_id").val())</script>');

        return $cfg;
    }
    
     function get_ajax_configuration($name, $value)
    {
        $cfg = array();

        switch ($name)
        {
            case 'fields_for_search_box':
                $entities_id = $value;

                //search by fields
                $choices = [];

                $fields_query = db_query("select f.*, t.name as tab_name from app_fields f, app_forms_tabs t where f.type in (" . fields_types::get_types_for_search_list() . ") and  f.entities_id='" . $entities_id . "'");
                while ($fields = db_fetch_array($fields_query))
                {
                    $choices[$fields['id']] = fields_types::get_option($fields['type'], 'name', $fields['name']);
                }

                $cfg[] = array('title' => "Pilih Field Keterangan",
                    'name' => 'fields_keterangan',
                    'type' => 'dropdown',
                    'choices' => $choices,
                    'tooltip_icon' => "Field ini nanti yang akan menampung Keterangan ketika diterima atau di tolak",
                    'params' => array('class' => 'form-control chosen-select input-xlarge', 'multiple' => false));
                    
                $cfg[] = array('title' => "Status",
                    'name' => 'fields_status',
                    'type' => 'dropdown',
                    'choices' => $choices,
                    'tooltip_icon' => "Field ini nanti yang akan menampung Status ketika diterima atau di tolak",
                    'params' => array('class' => 'form-control chosen-select input-xlarge', 'multiple' => false));
                
 
                break;
        }

        return $cfg;
    }
    
    function render($field,$obj,$params = array())
    {
        return '';
    }
    
    function process($options)
    {
        // return db_prepare_input($options['value']);
        // return "<script>alert('hallo')</script>";

    } 
    
    function output($options)
    {
        
        global $buttons_css_holder, $current_item_id;
        $config                  = json_decode($options['field']['configuration'],true);
        $config_entities         = $config['entity_id'];
        $config_field_keterangan = $config['fields_keterangan'][0];
        $config_field_status     = $config['fields_status'][0];
        $item_id                 = $options['item']['id'];
        
        $btn_group_id = 'filed_' . $options['field']['id'];
        $path = $options['path'];
        
        $query = db_query("select id,field_$config_field_keterangan,field_$config_field_status from app_entity_".$config_entities." where parent_item_id = '{$item_id}' order by id desc limit 1");
        
        $html  = '<button class="btn btn-primary" onclick="open_dialog(\'' . url_for('items/approve_lintar','status_approve=Setujui&path=' . $path.'&field_id='.$options['field']['id'].'&entities_id='.$options['field']['entities_id'].'&item_id='.$options['item']['id'].'&from_entities='.$config_entities.'&field_keterangan='.$config_field_keterangan.'&field_status='.$config_field_status) . '\');return false">Setujui</button>';
        $html .= '<button class="btn btn-danger" style="margin-left:10px" onclick="open_dialog(\'' . url_for('items/approve_lintar','status_approve=Tolak&path=' . $path.'&field_id='.$options['field']['id'].'&entities_id='.$options['field']['entities_id'].'&item_id='.$options['item']['id'].'&from_entities='.$config_entities.'&field_keterangan='.$config_field_keterangan.'&field_status='.$config_field_status) . '\');return false">Tolak</button>';
                
        
        while($q = db_fetch_array($query)){
            
            switch($q['field_'.$config_field_status]){
                
                case "Setujui":
                    $html =  "<b style='color:green'>Disetujui</b>";
                break;
                case "Tolak":
                    $html = '<button class="btn btn-info" onclick="open_dialog(\'' . url_for('items/approve_lintar','status_approve=Ulang&path=' . $path.'&field_id='.$options['field']['id'].'&entities_id='.$options['field']['entities_id'].'&item_id='.$options['item']['id'].'&from_entities='.$config_entities.'&field_keterangan='.$config_field_keterangan.'&field_status='.$config_field_status) . '\');return false">Ajukan Ulang</button>';
                break;
                default:
                    
                  
                break;
            }
        
                
          
        
        
        }
        
        
        
        
        
        return $html;
    }
    
}