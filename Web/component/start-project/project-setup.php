
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Project Title:</label>
    <div class="val">
        <input class="txt" type="text" id="txt_name1" placeholder="Project Title" value="">
    </div>
</div>
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Short Description:</label>
    <div class="val">
        <textarea class="txt fill-width" type="text" id="txt_desc" style="width: 300px;height: 100px;" placeholder="Short Description"></textarea>
    </div>
</div>
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Category:</label>
    <div class="val">
        <select name="category_id" class="txt" id="category_id" >
            <option value="">Select a Category...</option>
            <option value="1" >Internet / Web</option>
            <option value="2" >Mobile Applications</option>
            <option value="3" >Product Design</option>
            <option value="4" >Gaming</option>
            <option value="5" >Social Enterprises</option>
            <option value="6" >Other Technology</option>
            <option value="7" >Manga / Comics / Anime</option>
            <option value="8" >Film &amp; Video</option>
            <option value="9" >Music</option>
            <option value="10" >Crafts</option>
            <option value="11" >Other Creative / Arts</option>
        </select>
    </div>
</div>
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Country</label>
    <div class="val">
        <?php include "function/country.php"; ?>
    </div>
</div>
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Duration</label>
    <div class="val">
        <input class="txt" type="text" id="txt_duration" placeholder="" style="width: 75px;" value="">
        <b> Days</b>
    </div>
</div>
<div class="row-item clearfix">
    <label class="lbl" for="txt_name1">Your Target</label>
    <div class="val">
        <input class="txt" type="text" style="width: 100px;"  id="txt_target" placeholder="" value="">
        <b> $</b>
    </div>
</div>