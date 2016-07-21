
<div id="admin">
    <h2>Soon to be added here:</h2>
    <div class="row collapse">
        <div class="medium-3 columns">
            <ul class="tabs vertical" id="example-vert-tabs" data-tabs>
                <li class="tabs-title is-active"><a href="#panel1v" aria-selected="true">Name & Title</a></li>
                <li class="tabs-title"><a href="#panel2v">Favicon</a></li>
                <li class="tabs-title"><a href="#panel3v">Homepage</a></li>
                <li class="tabs-title"><a href="#panel4v">Widget</a></li>
                <li class="tabs-title"><a href="#panel5v">Footer</a></li>
                <li class="tabs-title"><a href="#panel6v">Update</a></li>
            </ul>
        </div>
        <div class="medium-9 columns">
            <div class="tabs-content vertical" data-tabs-content="example-vert-tabs">
                <div class="tabs-panel is-active" id="panel1v">
                    <p>
                        <form action="index.php?admin&site_name" method="post">
                            <h4>Site name change option</h4>
                            <input name="site_name" type="text" placeholder="<?php $this->settings['site_name']; ?>"/>
                            <input class="small button" type="submit" value= "Change"/>
                        </form>
                    </p>
                    <p>
                        <form action="index.php?admin&site_title" method="post">
                            <h4>Site title change option</h4>
                            <input name="site_title" type="text" placeholder="'.$this->settings['site_title'] .'"/>
                            <input class="small button" type="submit" value= "Change"/>
                        </form>
                    </p>
                </div>
                <div class="tabs-panel" id="panel2v">
                    <h4>Favicon settings</h4>
                    <p>Not there yet!</p>
                </div>
                <div class="tabs-panel" id="panel3v">
                    <h4>Homepage settings</h4>
                    <form action="index.php?admin&home_post_id" method="post">
                        <input name="home_post_id" type="text" placeholder="'. $this->settings['home_post_id'] .'"/>
                        <input class="small button" type="submit" value= "Change"/>
                    </form>
                </div>
                <div class="tabs-panel" id="panel4v">
                    <h4>Widget settings</h4>
                    <p>Soon to come! :)</p>
                </div>
                <div class="tabs-panel" id="panel5v">
                    <h4>Footer settings</h4>
                    <table>
                        <tr>
                            <th>Footer elements</th>
                            <th>Add/Remove</th>
                        </tr>
                        <tr>
                            <td><?php $this->footerForm(); ?></td>
                            <td>aa</td>
                        </tr>
                    </table>
                </div>
                <div class="tabs-panel" id="panel6v">
                    <h4><a href="?update">Update using git*</a></h4>
                    <small>* Git works with a script now and shouldn\'t update successful if installed on different enviroment.</small>
                    <h4>Changelog</h4><div class="panel"><?php $this->gitChangelog(); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
