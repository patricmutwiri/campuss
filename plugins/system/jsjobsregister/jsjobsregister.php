<?php
/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}

class plgSystemJSJobsRegister extends JPlugin
{
		function onUserBeforeSave($user,$isnew){
			//echo'<pre>';print_r($user);echo '</pre>';
			if( $isnew )
			{
				if(isset($_POST['userrole'])){
					$mainframe = JFactory::getApplication();
					$componentPath = JPATH_SITE.'/components/com_jsjobs';
                                        if(file_exists($componentPath.'/JSApplication.php')){
                                            require_once $componentPath.'/JSApplication.php';
                                            $db = JFactory::getDBO();
                                            $query = "SELECT  configvalue FROM  #__js_job_config where configname='user_registration_captcha' OR configname = 'captchause' ORDER BY configname";
                                            $db->setQuery( $query );
                                            $config =$db->loadObjectList();
                                            $redirect = 0;
                                            if(!isset($_POST['notcaptcha']))
                                            if($config[1]->configvalue==1){
                                                if($config[0]->configvalue == 0){
                                                    $post = JRequest::get('post');      
                                                    JPluginHelper::importPlugin('captcha');
                                                    if(JVERSION < 3)
                                                        $dispatcher = JDispatcher::getInstance();
                                                    else
                                                        $dispatcher = JEventDispatcher::getInstance();                                                
                                                    $res = $dispatcher->trigger('onCheckAnswer',$post['recaptcha_response_field']);
                                                    if(!$res[0]){
                                                        $redirect = 1;
                                                    }                                            
                                                }else{
                                                    if(!JSModel::getJSModel('common')->performChecks()){
                                                        $redirect = 1;
                                                    }
                                                }
                                                if($redirect == 1){
                                                    $msg = JText::_('ERROR_INCORRECT_CAPTCHA_CODE');
                                                    $link = "index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=".$_POST['userrole'];
                                                    $mainframe->redirect(JRoute::_($link), $msg);

                                                }
                                            }
                                        }
				   return true;
				}
			}
		}
		function onAfterStoreUser($user, $isnew, $success, $msg){ //j 1.5
			if( $isnew )
			{
				if(isset($_POST['userrole'])){
					$db = &JFactory::getDBO();
					$created = date('Y-m-d H:i:s');
					$query = "INSERT INTO #__js_job_userroles (uid,role,dated) VALUES (".$user['id'].", ".$user['userrole'].", '".$created."')";
					$db->setQuery( $query );
					$db->query();

					$componentAdminPath = JPATH_ADMINISTRATOR.'/components/com_jsjobs';
					$componentPath = JPATH_SITE.'/components/com_jsjobs';
                                        if(file_exists($componentPath.'/JSApplication.php')){
                                            require_once $componentPath.'/JSApplication.php';
                                            $result = JSModel::getJSModel('userrole')->addUser($_POST['userrole'],$user['id']);
                                        }
				}
			}
		}

		function onUserAfterSave($user, $isnew, $success, $msg){ //j 1.6 +
			if( $isnew ){
				if(isset($_POST['userrole'])){
					$db = &JFactory::getDBO();
					$created = date('Y-m-d H:i:s');
					$query = "INSERT INTO #__js_job_userroles (uid,role,dated) VALUES (".$user['id'].", ".$_POST['userrole'].", '".$created."')";
					$db->setQuery( $query );
					$db->query();
					$componentAdminPath = JPATH_ADMINISTRATOR.'/components/com_jsjobs';
					$componentPath = JPATH_SITE.'/components/com_jsjobs';
                                        if(file_exists($componentPath.'/JSApplication.php')){
                                            require_once $componentPath.'/JSApplication.php';
                                            $result = JSModel::getJSModel('userrole')->addUser($_POST['userrole'],$user['id']);
                                        }
				}
			}
		}

	   function onUserAfterDelete( $user, $success, $msg )
		{
			$db = &JFactory::getDBO();
			$query = 'DELETE FROM #__js_job_userroles WHERE uid ='.$user['id'];
			$db->setQuery( $query );
			$db->query();
			return true;
		}

		function onAfterDispatch()
        {
			$document = JFactory::getDocument();
			$content = $document->getBuffer('component');
			$option = JRequest::getVar('option');
			$view = JRequest::getVar('view');
	        $lang = JFactory::getLanguage();
	        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
			$html = $this->getRoleHTML();
//			$lang = JFactory::getLanguage();
//			$lang->load('plg_content_jsjobsregister', JPATH_ADMINISTRATOR);

			$version = new JVersion;
			$joomla = $version->getShortVersion();
			$jversion = substr($joomla,0,3);


			$newcontent = "";
			if($option == 'com_user' || $option == 'com_users'){
				if($view == 'register' || $view == 'registration'){
					if($jversion == '1.5')	$checkcontent = '<button class="button validate" type="submit">'.JTEXT::_('REGISTER').'</button>';
					elseif($jversion == '2.5') $checkcontent = '<button type="submit" class="validate">';
					else $checkcontent = '<button type="submit" class="btn btn-primary validate">';

					$newcontent = str_replace($checkcontent,$html.$checkcontent,$content);
				}
			}
			if($newcontent!="")	{
				$document->setBuffer($newcontent,'component');
			}
        }
		function getRoleHTML()
		{
                    if(!JFactory::getApplication()->isAdmin()){
			jimport( 'joomla.html.parameter' );
			$plugin 	= JPluginHelper::getPlugin('system', 'jsjobsregister');
			$version = new JVersion;
			$joomla = $version->getShortVersion();
			$jversion = substr($joomla,0,3);
			if($jversion == '2.5'){
				$params   	= json_decode($plugin->params);
				$this->params   	= new JParameter($plugin->params);
			}else{
				$this->params   	= new JRegistry();
				$this->params->loadString($plugin->params);
			} 
	        $lang = JFactory::getLanguage();
	        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
//			JPlugin::loadLanguage( 'plg_system_jsjobsregister', JPATH_ADMINISTRATOR );

			$componentAdminPath = JPATH_ADMINISTRATOR.'/components/com_jsjobs';
			$componentPath = JPATH_SITE.'/components/com_jsjobs';
                        if(file_exists($componentPath.'/JSApplication.php')){
                            require_once $componentPath.'/JSApplication.php';
                            $can_employer_register = JSModel::getJSModel('employer')->userCanRegisterAsEmployer();

                            $userregisterinrole = $this->params->get('userregisterinrole');
                            //$userregisterinrole = $params->userregisterinrole;

                            $jsrole = JRequest::getVar('jsrole');
                            if($userregisterinrole == 2) $jsrole = 1; // enforce employer
                            elseif($userregisterinrole == 3) $jsrole = 2; // enforce jobseeker

                            if($can_employer_register != true) $jsrole = 2; // enforce jobseeker

                            if ($jsrole == 1){ // employer
                                $rolehtml = "<input type='hidden' name='userrole' value='1'><input type='hidden' name='notcaptcha' value='1'>".JText::_('Employer');
                                $returnvalue = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                                                      <tr><td width=\"120\"  >".JText::_('Role').":</td><td >".$rolehtml."</td></tr></table>";
                            }elseif($jsrole == 2){
                            	$rolehtml = "<input type='hidden' name='notcaptcha' value='1'><input type='hidden' name='userrole' value='2'>".JText::_('Job Seeker');                                    	
                                $returnvalue = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                                                      <tr><td width=\"120\"  >".JText::_('Role').":</td><td >".$rolehtml."</td></tr></table>";
							}else{
                                    $rolehtml = "<select name='userrole'>
                                                            <option value='1'>".JText::_('Employer')."</option>
                                                            <option value='2'>".JText::_('Job Seeker')."</option>
                                                    </select><input type='hidden' name='notcaptcha' value='1'>";
                                    $returnvalue = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                                                      <tr><td width=\"120\"  >".JText::_('Role').":</td><td >".$rolehtml."</td></tr></table>";
                            }					
                            return $returnvalue;				
                        }
                    }
		}
		
}
?>
