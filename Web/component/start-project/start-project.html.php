
<div class="layout-2cols">
    <div class="content grid_8">
        <div class="single-page">
            <h2 class="rs single-title">Start Your Project</h2>
            <div class="box-single-content" style="width: 800px;">
                <div id="rootwizard">
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container" >
                                <ul >
                                    <li><a href="#tab1" data-toggle="tab">Project Setup</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Team Profile</a></li>
                                    <li><a href="#tab3" data-toggle="tab">Campaign Details</a></li>
                                    <li><a href="#tab4" data-toggle="tab">Rewards</a></li>
                                    <li><a href="#tab5" data-toggle="tab">Payment Info</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="bar" class="progress progress-striped active">
                        <div class="bar"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab1">
                            <div class="form form-profile">
                                <?php include 'component/start-project/project-setup.php'; ?>

                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form form-profile">
                                <?php include 'component/start-project/team-profile.php'; ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            3
                        </div>
                        <div class="tab-pane" id="tab4">
                            4
                        </div>
                        <div class="tab-pane" id="tab5">
                            5
                        </div>

                        <ul class="pager wizard">
                            <li class="previous first" style="display:none;"><a href="#">First</a></li>
                            <li class="previous"><a href="#">Previous</a></li>
                            <li class="next last" style="display:none;"><a href="#">Last</a></li>
                            <li class="next"><a href="#">Next</a></li>
                        </ul>
                    </div>	
                </div>
            </div>
        </div>
    </div><!--end: .content -->

    <div class="clear"></div>

</div>
