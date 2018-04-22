<?php     
    //show($partnerData);
    if( true == isset( $partnerData ) && true == is_array( $partnerData ) ) {
            $email       = $partnerData['email_id'];
            $name        = $partnerData['name'];
            $mobile      = $partnerData['mobile'];
            $designation = $partnerData['designation'];
            $profileType = ( false == $partnerData['is_featured'] ) ? 'Basic' : 'Featured';
    }
    ?>
    <div class="row white header-section">
        <div class="col l12 m12 s12">
            <div class="col l8 m8 s8">
                <h2 class="left-align page-title">My Account</h2>
            </div>
            <div class="col l4 m4 s4">  
                <div class="right-align">
                <a class="waves-effect waves-light jfh-transparent default-btn " href="<?php echo partner_base_url('profile') ?>">View profile</a>
                
            </div>
            </div>
        </div>      
    </div>
                    
        <div id="settings" class="container white padding25">
            <div class="row">
                <div class="col l12 m12 s12">
                        
                    <div class="left">
                        <span class="label">Full Name: </span>    
                    </div>

                    <div class="left view-details">
                        <span class="black-text"><?php echo $name ?></span>
                    </div>    
                    
                    <div class="left edit-details">
                        <input type="text" id="name" name="partner-name" value="<?php echo $name ?>" />
                        <a class="save" id="" href="">Save</a>
                        <a class="cancel" id="" href="">Cancel</a>
                    </div>
                    
                    <div class="left">    
                        <a id="change-name" class="change" href="">Change</a>       
                    </div>

                </div>
            </div>
            
            <div class="row">    

                <div class="col l12 m12 s12">
                    <div class="">
                        <span class="label gre-text">Email: </span>    
                        <span class="black-text"><?php echo $email ?></span>

                    </div>
                </div>
            </div>
            
            <div class="row">    

                <div class="col l12 m12 s12">
                        
                            <div class="left">
                                <span class="label">Mobile: </span>    
                            </div>

                            <div class="left view-details">
                                <span class="black-text"><?php echo $mobile ?></span>
                            </div>    
                            
                            <div class="left edit-details">
                                <input type="text" id="mobile" name="partner-mobile" value="<?php echo $mobile ?>" />
                                <a class="save" id="" href="">Save</a>
                                <a class="cancel" id="" href="">Cancel</a>
                            </div>
                            
                            <div class="left">    
                                <a id="change-name" class="change" href="">Change</a>       
                            </div>

                    
                </div>
            </div>
            
            <div class="">
                <a href="javascript:void(0)" id="change-password" class="waves-effect waves-light btn-large default-btn jfh-green">
                Change password</a>
            </div>

            <div id="change-password-section" class="hide">
                <form id="f-change-password" name="f-change-password" method="POST" action="<?php echo partner_base_url('change-password') ?>">
                    
                    <div class="row">
                        <div class="input-field">
                            <input type="password" class="required" name="old-password" id="old-password" value="">
                            <label for="old-password">Current Password</label>
                        </div>
                      
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="password" class="required" name="new-password" id="new-password" value="">
                            <label for="new-password">New Password</label>                  
                        </div>                                          
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="password" class="required" name="confirm-password" id="confirm-password" value="">
                            <label for="confirm-password">Re-type new password</label>
                               
                        </div>                                         
                    </div>

                    <div class="action-buttons">
                        <input class="waves-effect waves-light jfh-green default-btn" type="submit"  value="Submit">
                        <a href="javascript:void(0)" id="cancel-password" class="waves-effect waves-light default-btn jfh-transparent">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>    
        </div>   
