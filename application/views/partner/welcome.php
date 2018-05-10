<div id="" class="container white center-align">
    <?php 

    if( true == isset( $partnerData ) && true == is_array( $partnerData ) ) { ?>
    <h3>
        Hi, <?php echo ucwords( strtolower( $partnerData['contact_name'] ) ); ?>
    </h3>
    
    <div class="description" >
        <br/>You have now successfully registered with us!
        <h6 >Verification email has been sent to your email id. Please verify your email id.</h6>
       
    </div>

    <a class="daycare-green-round-btn btn margin20" href="<?php echo partner_base_url('create-branch')?>">CREATE PROFILE</a>

    <hr/>

    <div class="description center margin20">
        <h4> Need Help ?</h4>            
        <div class="row">
            <div class="col s6 m6 l6">
                <i class="material-icons">mail_outline</i>
                <a href="mailto:support@day-care.in" class="jfh-purple-text">support@day-care.in</a>
            </div>
            <div class="col s4 m6 l6 right">    
                <i class="material-icons">local_phone</i>+91 9923206515</a>
            </div>
        </div>        
    </div>
    <?php } else { ?>
     <div>Oops womething went wrong.....</div>   
    <?php } ?>    
        
</div>

