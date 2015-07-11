<!--<div class="layout-2cols">
    <div class="content grid_12">
        <h2>Informasi Member  </h2>
        <h3>Nama : <?php // echo $rows['name'];         ?></h3>
        <h3>Alamat : <?php // echo $rows['address'];         ?></h3>
        <h2>List Prospek</h2>
        <ul>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
        </ul>
        <h2>List Project</h2>
        <ul>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
                <li>Lorem Ipsum dolor sit amet</li>
        </ul>
    </div>end: .content 
    <div class="clear"></div>
</div>-->
<div class="container">
    <div class="row">
        <div class="container_12">
            <br />
            <h3 class="common-title">Informasi <span class="fc-orange">Member</span></h3>
            <div class="row">
                <div class="grid_3 text-center">
                    <img src="images/no-image.png" alt="" class="center-block img-circle img-responsive" width="75%">
                </div>
                <div class="grid_9">
                    <h2><?php echo $rows['name']; ?></h2>
                    <p><strong>Alamat: </strong> <?php echo $rows['address'] . ', ' . $rows['province']; ?></p>
                    <p><strong>Hobbies: </strong> Read, out with friends, listen to music, draw and learn new things. </p>
<!--                    <p><strong>Skills: </strong>
                        <span class="label label-info tags">html5</span> 
                        <span class="label label-info tags">css3</span>
                        <span class="label label-info tags">jquery</span>
                        <span class="label label-info tags">bootstrap3</span>
                    </p>-->
                </div>        
            </div>
            <!--User Additional Info-->
            <div class="row">
                <div class="grid_12">
                    <br />
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">List Prospek</h3>
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">List Project</h3>
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                                <li>Lorem Ipsum dolor sit amet</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="clear"></div>
    </div>    
</div>