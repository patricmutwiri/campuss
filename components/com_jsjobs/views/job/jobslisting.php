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
class jobslist {

    private $fields;

    function __construct() {
        $this->fields = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(2);
    }

    function printjobs(&$jobs, &$config, &$fieldsordering ,&$Itemid){
        $user = JFactory::getUser(); 
        $role = JSModel::getJSModel('userrole')->getUserRole($user->id);       
        $showgoogleadds = $config['googleadsenseshowinlistjobs'];
        $afterjobs = $config['googleadsenseshowafter'];
        $googleclient = $config['googleadsenseclient'];
        $googleslot = $config['googleadsenseslot'];
        $googleaddhieght = $config['googleadsenseheight'];
        $googleaddwidth = $config['googleadsensewidth'];
        $googleaddcss = $config['googleadsensecustomcss'];

        $html = "";
        $date_now = date('Y-m-d H:i:s');
        $noofjobs = 1;
        foreach ($jobs as $job) { 
            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyid);
            $link_viewcomp = "index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=" . $companyaliasid . "&Itemid=" . $Itemid;
            $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
            $link_viewjob = "index.php?option=com_jsjobs&c=job&view=job&layout=view_job&bd=".$jobaliasid."&Itemid=".$Itemid;
            if($job->logofilename != ""){
                $datapath = $config['data_directory'];
                $path = JURI::root().$datapath.'/data/employer/comp_'.$job->companyid.'/logo/'.$job->logofilename;
            }else{ 
                $path = JURI::root().'components/com_jsjobs/images/blank_logo.png';
            }
            $expiredate = date('Y-m-d H:i:s', strtotime($job->created.'+ '.$config['newdays'].' days'));
            if($config['labelinlisting'] == 1){
                $hourago = JText::_('Posted').": ";
            }else{
                $hourago = "";
            }
            $startTimeStamp = strtotime($job->created);
            $endTimeStamp = strtotime("now");
            $timeDiff = abs($endTimeStamp - $startTimeStamp);
            $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
            // and you might want to convert to integer
            $numberDays = intval($numberDays);
            if ($numberDays != 0 && $numberDays == 1) {
                $day_text = JText::_('Day');
            } elseif ($numberDays > 1) {
                $day_text = JText::_('Days');
            } elseif ($numberDays == 0) {
                $day_text = JText::_('Today');
            }
            if ($numberDays == 0) {
                $hourago .= $day_text;
            } else {
                $hourago .= $numberDays.' '.$day_text.' '.JText::_('Ago');
            }

            $html .='<div id="js-jobs-wrapper">';
            $html .=    '<div class="js-toprow">';
                $html .=        '<div class="js-image">';
            $_field = $this->getFieldStatus('company');
            if($_field[0] == 1 ){
                $html .=            '<a href="'.$link_viewcomp.'"><img src="'.$path.'" title="'.$job->companyname.'"></a>';
            }
                $html .=        '</div>';                
            $html .=        '<div class="js-data">';
            $html .=            '<div class="js-first-row">';
            $html .=                '<span class="js-col-xs-12 js-col-md-6 js-title js-title-tablet"> ';            
            $html .=                    '<a class="jobtitle" href="'.$link_viewjob.'">'.$job->title;
            $html .=            '</a>';
                                            if($date_now < $expiredate){
                $html .=                        '<span class="js-status bg-new">'.JText::_("New").'</span>';
                                            }

                
                $html .=                '</span>';

            $html .=                '<span class="js-col-xs-12 js-col-md-6 js-jobtype js-jobtype-tablet">';
            $html .=    $hourago;

            $_field = $this->getFieldStatus('jobtype');
            if($_field[0] == 1 ){
                $html .=  '<span class="js-type">'.JText::_($job->jobtypetitle).'</span>';
            }
            $html .= '</span>';


            $html .=            '</div>';

            $html .=            '<div class="js-second-row">';
            // $_field = $this->getFieldStatus('company');
            // if($_field[0] == 1 ){
            //     $html .=            '<a class="jsjobs-listing-company" href="'.$link_viewcomp.'">'.$job->companyname.'</a>';
            // }            
            $html .=                '<div class="js-col-xs-12 js-col-md-5 js-fields">';
            $_field = $this->getFieldStatus('jobcategory');
            if($_field[0] == 1 ){
                if($config['labelinlisting'] == 1){
                $html .=                        '<span class="js-bold">' .JText::_($_field[1]).': </span>';
                }
                $html .=                JText::_($job->cat_title);
            }

            $html .='</div>';
            $html .=                '<div class="js-col-xs-12 js-col-md-5 js-fields">';
            $_field = $this->getFieldStatus('jobsalaryrange');
            if($_field[0] == 1 ){
                if($config['labelinlisting'] == 1){
                $html .=                        '<span class="js-bold">' .JText::_($_field[1]).': </span>';
                }
                $html .=                $job->salary;
            }
                    $html .='</div>';
            $html .=                '<div class="js-col-xs-12 js-col-md-2 js-fields no-padding"> ';

            $_field = $this->getFieldStatus('noofjobs');
            if($_field[0] == 1 ){
                $html .=            '<span class="js-totaljobs">'.$job->noofjobs.' '.JText::_('Jobs').'</span>';
            }
                $html .='</div>';
                
                $customfields = getCustomFieldClass()->userFieldsData( 2 , 1);
                foreach ($customfields as $field) {
                    $html .= getCustomFieldClass()->showCustomFields($field, 1 ,$job , $config['labelinlisting']);
                }                    

            $html .=            '</div>
                            </div>
                        </div>';
            $html .=    '<div class="js-bottomrow">';
            $html .=        '<div class="js-col-xs-12 js-col-md-8 js-address">';

            $_field = $this->getFieldStatus('city');
            if($_field[0] == 1 ){
                $html .= '<img class="location" src="'.JURI::root().'/components/com_jsjobs/images/location.png">'.$job->location;
            }
            $html .='</div>';


            $html .=        '<div class="js-col-xs-12 js-col-md-4 js-actions">';

            if($config['showapplybutton']==1){
                if($job->jobapplylink == 1 && !empty($job->joblink)){
                    if(!strstr('http',$job->joblink)){
                        $job->joblink = 'http://'.$job->joblink;
                    }
                    $target = 'target="_blank"';
                    if (filter_var($job->joblink, FILTER_VALIDATE_URL) === false) {
                        $job->joblink = '#';
                        $target = '';
                    }
                    $html .= '<a class="js-btn-apply" href="'.$job->joblink.'" '.$target.' >'.JText::_('Apply Now').'</a>';
                }elseif(!empty($config['applybuttonredirecturl'])){
                    $html .= '<a class="js-btn-apply" href="'.$config['applybuttonredirecturl'].'" target="_blank">'.JText::_('Apply Now').'</a>';
                }else{
                    $html .='<a class="js-btn-apply" href="#" onclick="getApplyNowByJobid('.$job->jobid.');">'.JText::_('Apply Now','js-jobs').'</a>';
                }
            }
            $html .=        '</div>
                        </div>
                    </div>'; // END Main ROW WRAPPER

                if ($showgoogleadds == 1) {
                    if ($noofjobs % $afterjobs == 0) {
                        $html .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" style="'.$googleaddcss.'">
                                        <tr>
                                            <td>
                                                <script type="text/javascript">
                                                    google_ad_client = "' . $googleclient . '";
                                                    google_ad_slot = "' . $googleslot . '";
                                                    google_ad_width = "' . $googleaddwidth . '";
                                                    google_ad_height = "' . $googleaddhieght . '";
                                                </script>
                                                <script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                                            </td>
                                        </tr>
                                    </table>';
                    } $noofjobs++;
                }

        }

        $nextpage = JRequest::getVar('pagenum', 0);
        $nextpage += 1;
        $html .= '<a class="scrolltask" data-scrolltask="getNextJobs" data-offset="'.$nextpage.'"></a>';
        return $html;
    }

    function getFieldStatus($field){
        $return[0] = false;
        $return[1] = '';
        foreach($this->fields AS $f){
            if($f->field == $field){
                $return[0] = $f->showonlisting;
                $return[1] = $f->fieldtitle;
                break;
            }
        }
        return $return;
    }
}
?>