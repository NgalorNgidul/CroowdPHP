<div class="project-tab-detail tabbable accordion">
    <ul class="nav nav-tabs clearfix">
        <li class="active"><a href="#">Informasi</a></li>
        <li><a href="#" class="be-fc-orange">Updates (0)</a></li>
        <li><a href="#" class="be-fc-orange">Investor (270)</a></li>
        <!--<li><a href="#" class="be-fc-orange">Komentar (2)</a></li>-->
    </ul>
    <div class="tab-content">
        <div>
            <h3 class="rs alternate-tab accordion-label">Informasi</h3>
            <div class="tab-pane active accordion-content">
                <div class="editor-content">
                    <h3 class="rs title-inside"><?= $data->title; ?></h3>
                    <p class="rs post-by">oleh <a href="#" class="fw-b fc-gray be-fc-orange"><?= $data->ownerName; ?></a> di <span class="fw-b fc-gray"><?= $data->location; ?>, <?= $data->province; ?></span></p>
<!--                    <p>Nam sit amet est sapien, a faucibus purus. Sed commodo facilisis tempus. Pellentesque placerat elementum adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                    <p>
                        <img class="img-desc" src="images/ex/th-552x411-2.jpg" alt="$DESCRIPTION"/>
                        <span class="img-label">Me and project friends on meeting</span>
                    </p>
                    <p>Nam sit amet est sapien, a faucibus purus. Sed commodo facilisis tempus. Pellentesque placerat elementum adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                    -->
                    <div style="text-align: justify;">
                        <img class="img-desc" style="float: left; margin: 0 9px 3px 0;" src="<?= $data->smallImage; ?>" alt="$DESCRIPTION"/>
                        <?= $data->shortDescription; ?>
                    </div>
                    <!-- AddThis Button BEGIN -->
                    <div class="social-sharing">
                        <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                        </div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
                        <!-- AddThis Button END -->
                    </div>
                </div>
                <div class="project-btn-action">
                    <a class="btn big btn-red" href="#">Ask a question</a>
                    <a class="btn big btn-black" href="#">Report this project</a>
                </div>
            </div><!--end: .tab-pane(About) -->
        </div>
        <div>
            <h3 class="rs alternate-tab accordion-label">Updates (0)</h3>
            <div class="tab-pane accordion-content">
                <div class="tab-pane-inside">
                    <div class="list-last-post">
                        <div class="media other-post-item">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-1.jpg" alt="$TITLE">
                            </a>
                            <div class="media-body">
                                <h4 class="rs title-other-post">
                                    <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                </h4>
                                <p class="rs fc-gray time-post pb10">posted 5 days ago</p>
                                <p class="rs description">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            </div>
                        </div><!--end: .other-post-item -->
                        <div class="media other-post-item">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-2.jpg" alt="$TITLE">
                            </a>
                            <div class="media-body">
                                <h4 class="rs title-other-post">
                                    <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                </h4>
                                <p class="rs fc-gray time-post pb10">posted 5 days ago</p>
                                <p class="rs description">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            </div>
                        </div><!--end: .other-post-item -->
                        <div class="media other-post-item">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-3.jpg" alt="$TITLE">
                            </a>
                            <div class="media-body">
                                <h4 class="rs title-other-post">
                                    <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                </h4>
                                <p class="rs fc-gray time-post pb10">posted 5 days ago</p>
                                <p class="rs description">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            </div>
                        </div><!--end: .other-post-item -->
                        <div class="media other-post-item">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-4.jpg" alt="$TITLE">
                            </a>
                            <div class="media-body">
                                <h4 class="rs title-other-post">
                                    <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                </h4>
                                <p class="rs fc-gray time-post pb10">posted 5 days ago</p>
                                <p class="rs description">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            </div>
                        </div><!--end: .other-post-item -->
                        <div class="media other-post-item">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-1.jpg" alt="$TITLE">
                            </a>
                            <div class="media-body">
                                <h4 class="rs title-other-post">
                                    <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                </h4>
                                <p class="rs fc-gray time-post pb10">posted 5 days ago</p>
                                <p class="rs description">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            </div>
                        </div><!--end: .other-post-item -->
                    </div>
                </div>
            </div><!--end: .tab-pane(Updates) -->
        </div>
        <div>
            <h3 class="rs alternate-tab accordion-label">Investor (270)</h3>
            <div class="tab-pane accordion-content">
                <div class="tab-pane-inside">
                    <div class="project-author pb20">
                        <div class="media">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-1.jpg" alt="$USER_NAME"/>
                            </a>
                            <div class="media-body">
                                <h4 class="rs pb10"><a href="#" class="be-fc-orange fw-b">John Doe</a></h4>
                                <p class="rs">Chicago, IL</p>
                                <p class="rs fc-gray">5 projects</p>
                            </div>
                        </div>
                    </div><!--end: .project-author -->
                    <div class="project-author pb20">
                        <div class="media">
                            <a href="#" class="thumb-left">
                                <img src="images/ex/th-90x90-1.jpg" alt="$USER_NAME"/>
                            </a>
                            <div class="media-body">
                                <h4 class="rs pb10"><a href="#" class="be-fc-orange fw-b">John Doe</a></h4>
                                <p class="rs">Chicago, IL</p>
                                <p class="rs fc-gray">5 projects</p>
                            </div>
                        </div>
                    </div><!--end: .project-author -->
                </div>
                <div class="project-btn-action">
                    <a class="btn btn-red" href="#">Ask a question</a>
                    <a class="btn btn-black" href="#">Report this project</a>
                </div>
            </div><!--end: .tab-pane(Backers) -->
        </div>
        <div>
            <h3 class="rs active alternate-tab accordion-label">Comments (2)</h3>
            <div class="tab-pane accordion-content">
                <div class="box-list-comment">
                    <div class="media comment-item">
                        <a href="#" class="thumb-left">
                            <img src="images/ex/th-90x90-1.jpg" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">John Doe</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content"> Fusce tellus. Sed metus augue, convallis et, vehicula ut, pulvinar eu, ante. Integer orci tellus, tristique vitae, consequat nec, porta vel, lectus</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                    <div class="media comment-item">
                        <a href="#" class="thumb-left">
                            <img src="images/ex/th-90x90-2.jpg" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">Eminem</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor. Pellentesque faucibus. Ut accumsan ultricies elit.</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                    <div class="media comment-item lv2">
                        <a href="#" class="thumb-left">
                            <img src="images/ex/th-90x90-3.jpg" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">Snoop Dogg</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                    <div class="media comment-item lv2">
                        <a href="#" class="thumb-left">
                            <img src="images/ex/th-90x90-4.jpg" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">Obama</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content">Curabitur vel dolor ultrices ipsum dictum tristique. Praesent vitae lacus. Ut velit enim, vestibulum non, fermentum nec,</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                    <div class="media comment-item lv3">
                        <a href="#" class="thumb-left">
                            <img src="images/no-avatar.png" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">Mark Lenon</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content">Nam nec sem ac risus congue varius. Maecenas interdum ipsum tempor ipsum fringilla eu vehicula urna vehicula.</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                    <div class="media comment-item">
                        <a href="#" class="thumb-left">
                            <img src="images/ex/th-90x90-1.jpg" alt="$TITLE">
                        </a>
                        <div class="media-body">
                            <h4 class="rs comment-author">
                                <a href="#" class="be-fc-orange fw-b">Dr. Dre</a>
                                <span class="fc-gray">say:</span>
                            </h4>
                            <p class="rs comment-content"> Morbi eget arcu. Morbi porta, libero id ullamcorper nonummy, nibh ligula pulvinar metus, eget consectetuer augue nisi quis lacus. Ut ac mi quis lacus mollis aliquam. Curabitur iaculis tempus eros. Curabitur vel mi sit amet magna malesuada ultrices</p>
                            <p class="rs time-post">5 days ago</p>
                        </div>
                    </div><!--end: .comment-item -->
                </div>
            </div><!--end: .tab-pane(Comments) -->
        </div>
    </div>
</div><!--end: .project-tab-detail -->