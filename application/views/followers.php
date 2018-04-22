<?php 
    $isFeatured = $partnerData['is_featured'];
    $partnerId = $partnerData['vendor_id'];
    $logo = ( true == empty( $vendorData['logo'] ) ) ? generate_image_url('images/reskilling/default-partner-icon.png') : generate_image_url( 'images/reskilling/desktop/vendors/' . $vendorData['logo'] );
?>
<input type="hidden" name="follower-partnerid" id="follower-partnerid" value="<?php echo $partnerId ?>" />
<input type="hidden" name="targetEntityTypeId" id="targetEntityTypeId" value="<?php echo PARTNER_TYPE_ID ?>"/>
<div class="row white header-section">
    <div class="col l12 m12 s12">
        <div class="col l8 m8 s8">
            <h2 class="left-align page-title">Followers</h2>
        </div>
    </div>      
</div>

<div class="container pad20">
    
    <?php if( false == $isFeatured ) { ?>
    <div class="row white">
        <div class="col l12 m12 s12 center-align">
            <h1 class="warning-message">Oh no! You've hit a brick wall.</h1>
            <img class="no-featured" src="<?php echo generate_image_url('images/brick.jpg') ?>" />
            <div>
                Only Featured Partners are allowed beyond this point <br/>
            </div>
        </div>
    </div>
    <?php } else {        
    ?>    
    <div id="partner-followers" class="desktop-dashboard desktop-myprofile hr-view-hold job-posting-employ dashboard-2 shared-profile job-application">
        <div class="wrapper"> 
            <div class="row">
                <div class="col l3 m3 s12" id="">
                    <div class="card center padding25">
                        <a class="block" href="<?php echo partner_base_url('profile') ?>">
                            <img id="profile-image" src="<?php echo $logo  ?>" />
                        </a>
                        <h4><?php echo $vendorData['legal_name'] ?><h4>
                        <?php if( $vendorData['is_featured'] == 1 ){ ?>
                            <span class="sprite reskilling-hot-icon"></span>
                        <?php } ?>

                        <hr/>
                        Profile Views: <?php echo $vendorData['profile_view_count'] ?>
                    </div>
               </div>

                <div class="col m9 l9 s12 sec-box-application">
                    
                    <div id="filters-wrapper">
                        <div class="row white">
                            <div class="col m12 pad0 border-bottom l12 s12">
                                <div class="application-box">
                                    <div class="input-field status-filter">
                                        <select id="label_filter">
                                            <option value="" >Status</option>
                                            <option value="Starred">Starred</option>
                                            <option value="Not_Starred">Not Starred</option>
                                            <option value="Y">Viewed</option>
                                            <option value="N">Not Viewed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col m12 pad0 keyword-containing l12 s12">
                                <div class="col m6 l3 s12">
                                    <div class="search-wrapper card focused border-all ">
                                        <input id="search" placeholder="Keywords">
                                    </div>
                                </div>
                                
                                <div class="col m6 l3 s12 loc-bx">
                                    <div class="input-field fields-hold click-hide">
                                        
                                        <select id="applied-city" name="applied-cities[]" multiple class="input-tags demo-default s1" >
                                            <option value="">Select City</option>                          
                                            <?php
                                            $mtmpst = true;
                                            $ctmpst = true;

                                            foreach ($cities as $key => $value) {
                                                if($value['ordinal'] > 0 && $mtmpst){
                                                    echo '<optgroup label="----- Top Metropolitan Cities -----">';
                                                    $mtmpst = false;
                                                }elseif($value['ordinal'] == 0 && $ctmpst && ! $mtmpst){
                                                    echo '</optgroup><optgroup label="----- Other Cities -----">';
                                                    $ctmpst = false;
                                                }
                                                $defValue = 'value="' . $value['id'] . '"';
                                                 
                                                echo '<option ' . $defValue . '>' . $value['label'] . '</option>';
                                                
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                                
                                <div class="col m3 l2 s12">
                                    <div class="input-field choose-job new-choose">
                                        <select id="func_areas">
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col m3 l2 s12">
                                    <div class="input-field choose-job new-choose">
                                        <select id="indus">

                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col m3 l2 s12">
                                    <div class="input-field choose-job new-choose">
                                        <select id="exp">
                                            <option value="">Experience</option>
                                            <?php
                                            echo '<option value="0">0-1</option>';
                                            for ($i = 1; $i <= 30; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '+</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="filter-buttons-altered col m12 s12 l6 pad0 ">
                                <div class="filt">
                                    <button class="waves-effect waves-light jfh-green default-btn" id="filter-btn">Filter</button>
                                </div>
                                <div class="rst">
                                    <button class="waves-effect waves-light jfh-transparent default-btn rst" onclick="reset()">Reset</button>
                                </div>
                            </div>

                        </div>
                    </div>

                        <div id="select-all-wrapper" >
                            <div class="sel-all">
                                <input type="checkbox" id="select-all-followers" name="sel_all"/>
                                <label id="" for="select-all-followers"> Select All</label>
                                <span id="follower-count"></span>
                            </div>
                            
                            <div class="pre-lder-holder" id="loader_circle">
                                 <img src="<?php echo generate_image_url('images/loading.gif')?>">
                            </div>
                                                    
                            <div id="selectall-details" class="hide">
                                <div class="row">
                                    <div class="col m12 border-bottom light-grey padding-15 l12 s12">
                                        
                                            
                                        <div class="row">
                                            <div class="col m7 pad0 l7 s12 sel-chk-bx">
                                                
                                                <input type="checkbox" id="selected-followers" />
                                                <span id="selected-follower-count"></span>
                                                
                                                <a href="" class="waves-effect waves-light btn-small trans-btn" id="bulk-email">Send Email</a>
                                                <a class="waves-effect waves-light btn-small " id="bulk-starred">Starred</a>
                                                <a class="waves-effect waves-light btn-small trans-btn" id="bulk-not-starred">Not Starred</a>
                                            </div>

                                            <div class="col m5 right-align pad0 l5 s12 dlt-alne">

                                                <a class="waves-effect waves-light btn-small excl-sheet-btn trans-btn" href="" id="exportToExcel">Export to Excel</a> 
                                            </div>

                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>




                    <form id="frm-bulk-actions" name="export-candidate" action="<?php echo base_url('employer/jobapplication/export_candidate_details/1')?>" method="post">
                    <div id="follower_details" class="follower_details_main">
                        
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
