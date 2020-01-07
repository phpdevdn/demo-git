<?php 
use OlTheme\Helpers\OlForm;
$infomation=get_option('oltheme_information');
$info_def = array(
    'address' => '',
    'phone' => '',
    'email'=>'',
    'facebook'=>'',
    'google'=>'',
    'youtube'=>''
    );
 $info_ar=unserialize($infomation);
 $info_ar = (empty($info_ar)) ? $info_def : array_merge($info_def,$info_ar);
 $link_update = $this->getLink(['action' => 'update_general']);
 ?>
<form action="<?php echo $link_update; ?>" method="post" class="olform">
    <?php echo wp_nonce_field(); ?> 
     <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"> <label><b>Infomation</b></label> </th>
                <td>
                    <div class="olct">
                        <ul class="ollst">
                            <li>
                                <?php OlForm::textarea('info[address]',$info_ar['address'],'Address'); ?>
                            </li>
                            <li>
                                <?php OlForm::text('info[phone]',$info_ar['phone'],'phone hotline'); ?>
                            </li>
                            <li>
                                <?php OlForm::text('info[email]',$info_ar['email'],'Email'); ?>
                            </li>
                            <li>
                                <?php OlForm::text('info[facebook]',$info_ar['facebook'],'Facebook'); ?>
                            </li>
                            <li>
                                <?php OlForm::text('info[google]',$info_ar['google'],'Google'); ?>
                            </li>                                        
                            <li>
                                <?php OlForm::text('info[youtube]',$info_ar['youtube'],'Youtube'); ?>
                            </li>                                     
                        </ul>    
                    </div>
                </td>
            </tr>                 
        </tbody>
    </table>
     <?php submit_button(); ?>
</form> 