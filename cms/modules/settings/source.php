<?php

class Settings
{
	public $languages = array();
	public $system;
	public $settings = array();
	public $siteSettings;
	
	function __construct($params = array()) {
		$this->system = $params['system'];

		$this->settings = Db::fetchRows('SELECT * '.
			'FROM `tm_settings` '.
            'WHERE `setting` != "dashboard" '.
			'ORDER BY `position` ASC, `setting` ASC'
		);
		
		$i = 0;
		foreach($this->settings as $v) {
            //If ssl is not enabled, not displaying this options or it will just break the website
            if($v->setting == 'https' && !extension_loaded('openssl')) {
                break;
            }
            
            $this->siteSettings[$i]['type'] = $v->type;
            $this->siteSettings[$i]['position'] = $v->position;
            
            if ($v->field) {
                $this->siteSettings[$i]['value'] = $v->field;
            }
            else {
                $this->siteSettings[$i]['value'] = at($v->setting);
            }
            
            $hint = array(0=>'',1=>'');
            if (at('hint_'.$v->setting) != 'hint_'.$v->setting) {
                $hint[0] = 'hint';
                $hint[1] = at('hint_'.$v->setting);
            }
        
            if ($v->type == 'level') {
                $this->siteSettings[$i]['html'] = '<div id="setting-'.$v->setting.'" class="pointer settings_div '.$hint[0].'" name="'.$hint[1].'" onclick="TM.addInput(\'setting-'.$v->setting.'\', 1);">'.$v->value.'</div>';
            }
            else if ($v->type == 'checkbox') {
				$this->siteSettings[$i]['html'] = '<input type="checkbox" id="'.$v->setting.'" class="save_setting_checkbox '.$hint[0].'" name="'.$hint[1].'" value="'.$v->value.'" '.($v->value==1?'checked="checked"':null).'/>';
			}
			else if ($v->type == 'text') {
				$this->siteSettings[$i]['html'] = '<div id="setting-'.$v->setting.'" class="pointer settings_div '.$hint[0].'" name="'.$hint[1].'" onclick="TM.addInput(\'setting-'.$v->setting.'\', 0);">'.$v->value.'</div>';
			}
			else {
				$this->siteSettings[$i]['html'] = 'For config "'.$v->setting.'" type is not set, this is an error!';
			}
			++$i;
		}

		return $this;
	}

}