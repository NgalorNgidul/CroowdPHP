<div class="form login-form">
    <form action="#">
        <h3 class="rs title-form">Register</h3>
        <h4 class="rs title-box">Masukkan informasi anda</h4>
        <p class="rs">Masukkan nama anda serta alamat email sehingga kami bisa mengirimkan email untuk proses validasi.</p>
        <div class="form-action">
            <label for="txt_name">
                <input id="txt_name" class="txt fill-width" type="text" placeholder="Masukkan nama lengkap anda"/>
            </label>
            <label for="txt_email">
                <input id="txt_email" class="txt fill-width" type="email" placeholder="Masukkan alamat email"/>
            </label>
            <label for="txt_re_email">
                <input id="txt_re_email" class="txt fill-width" type="email" placeholder="Verifikasi alamat email"/>
            </label>

            <label for="txt_password">
                <input id="txt_password" class="txt fill-width" type="password" placeholder="Masukkan password"/>
            </label>
            <label for="txt_re_password">
                <input id="txt_re_password" class="txt fill-width" type="password" placeholder="Verifikasi password"/>
            </label>
            <label for="txt_accept">
                <input type="checkbox" value="1" required="required" name="member" id="member_accept_principles">
            Saya setuju dengan aturan-aturan keanggotaan Croowd
            </label>
            <label for="txt_receive">
                <input type="checkbox" value="1" checked="checked" required="required" name="receive" id="member_receive_principles">
            Saya ingin menerima email-email update dari Croowd
            </label>
            
<br/>
            <p class="rs pb10">Dengan ini anda setuju dengan <a href="#" class="fc-orange">aturan keanggotaan kami</a> dan <a href="#" class="fc-orange">aturan penyimpanan data kami</a>.</p>
            <p class="rs ta-c">
                <button class="btn btn-red btn-submit" type="submit">Kirim</button>
            </p>
        </div>
    </form>
</div>
