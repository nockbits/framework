<?php if($err_msg){ ?>
<div class="err">
  <b>Errors:</b><br/>
  &nbsp;<?php __e($err_msg);?>
</div>
<?php } ?>

<form name="frm1" id="frm1" class="frm1" method="post" action="">
  <input type="hidden" name="cm" value="add" />
  <input type="hidden" name="ct" value="<?php __e($ts);?>" />
  <div class="box col1">

  <h2 class="h2c">Contact Us</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">First Name <span>*</span></td>
      <td class="sep">:</td>
      <td><input type="text" name="txtFName" id="txtFName" value="<?php __e($_POST['txtFName']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Email Id <span>*</span></td>
      <td class="sep">:</td>
      <td><input type="text" name="txtEmail" id="txtEmail" value="<?php __e($_POST['txtEmail']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Telephone</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtTel" id="txtTel" value="<?php __e($_POST['txtTel']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">City</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtCity" id="txtCity" value="<?php __e($_POST['txtCity']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">State</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtState" id="txtState" value="<?php __e($_POST['txtState']);?>" maxlength="25" class="in"/></td>
    </tr>
  </table>

  <br class="clearfix"/>
</div>
<div class="box col2">
  <h2 class="h2c">&nbsp;</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">Last Name</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtLName" id="txtLName" value="<?php __e($_POST['txtLName']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Mobile <span>*</span></td>
      <td class="sep">:</td>
      <td><input type="text" name="txtMobile" id="txtMobile" value="<?php __e($_POST['txtMobile']);?>" maxlength="120" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Address</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtAddr" id="txtAddr" value="<?php __e($_POST['txtAddr']);?>" maxlength="250" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Postcode</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtPostcode" id="txtPostcode" value="<?php __e($_POST['txtPostcode']);?>" maxlength="10" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">Country</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtCountry" id="txtCountry" value="<?php __e($_POST['txtCountry']);?>" maxlength="25" class="in"/></td>
    </tr>
  </table>
  <br class="clearfix"/>
</div>

<div class="box col1">
  <h3 class="h2c">Educational Information</h3>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">SSC (X)</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtEduSsc" id="txtEduSsc" value="<?php __e($_POST['txtEduSsc']);?>" maxlength="20" class="insm"/> (% or Grade)</td>
      <td><input type="text" name="txtEduSscYr" id="txtEduSscYr" value="<?php __e($_POST['txtEduSscYr']);?>" maxlength="4" class="insm"/> (Year)</td>
    </tr>

    <tr>
      <td class="hd">Graduation Field</td>
      <td class="sep">:</td>
      <td colspan="2"><input type="text" name="txtEduGradFld" id="txtEduGradFld" value="<?php __e($_POST['txtEduGradFld']);?>" maxlength="100" class="in"/></td>
    </tr>

    <tr>
      <td class="hd">Other</td>
      <td class="sep">:</td>
      <td colspan="2"><input type="text" name="txtEduOtherFld" id="txtEduOtherFld" value="<?php __e($_POST['txtEduOtherFld']);?>" maxlength="100" class="in"/></td>
    </tr>
  </table>

  <br class="clearfix"/>
</div>
<div class="box col2">
  <h2 class="h2c">&nbsp;</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">HSC (XII)</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtEduHsc" id="txtEduHsc" value="<?php __e($_POST['txtEduHsc']);?>" maxlength="20" class="insm"/> (% or Grade)</td>
      <td><input type="text" name="txtEduHscYr" id="txtEduHscYr" value="<?php __e($_POST['txtEduHscYr']);?>" maxlength="4" class="insm"/> (Year)</td>
    </tr>
    <tr>
      <td class="hd">Graduation Info</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtEduGrad" id="txtEduGrad" value="<?php __e($_POST['txtEduGrad']);?>" maxlength="20" class="insm"/> (% or Grade)</td>
      <td><input type="text" name="txtEduGradYr" id="txtEduGradYr" value="<?php __e($_POST['txtEduGradYr']);?>" maxlength="4" class="insm"/> (Year)</td>
    </tr>
    <tr>
      <td class="hd">Other Info</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtEduOther" id="txtEduOther" value="<?php __e($_POST['txtEduOther']);?>" maxlength="20" class="insm"/> (% or Grade)</td>
      <td><input type="text" name="txtEduOtherYr" id="txtEduOtherYr" value="<?php __e($_POST['txtEduOtherYr']);?>" maxlength="4" class="insm"/> (Year)</td>
    </tr>
  </table>
  <br class="clearfix"/>
</div>

<div class="box col1">
  <h3 class="h2c">Other Information</h3>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">

    <tr>
      <td class="hd">Category</td>
      <td class="sep">:</td>
      <td>
        <select name="selCategory" id="selCategory" class="in">
          <option value="">Please select</option>
          <option value="Student">Student</option>
          <option value="Technical/IT">Technical/IT</option>
          <option value="Medical/Doctor/Dental">Medical/Doctor/Dental</option>
          <option value="Advertising/Media">Advertising/Media</option>
          <option value="Self Employed">Self Employed</option>
          <option value="Other">Other</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="hd">General Exam</td>
      <td class="sep">:</td>
      <td>
        <select name="selGenExam" id="selGenExam" class="in">
          <option value="">Please select</option>
          <option value="IELTS">IELTS</option>
          <option value="GMAT">GMAT</option>
          <option value="TOEFL">TOEFL</option>
          <option value="GRE">GRE</option>
          <option value="None">None</option>
          <option value="Other">Other</option>
        </select>
      </td>
    </tr>
  </table>

  <br class="clearfix"/>
</div>
<div class="box col2">
  <h2 class="h2c">&nbsp;</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">Experience</td>
      <td class="sep">:</td>
      <td><input type="text" name="txtExperience" id="txtExperience" value="<?php __e($_POST['txtExperience']);?>" maxlength="100" class="in"/></td>
    </tr>
    <tr>
      <td class="hd">You heard about us?</td>
      <td class="sep">:</td>
      <td>
        <select name="selHeardAbt" id="selHeardAbt" class="in">
          <option value="">Please select</option>
          <option value="Website">Website</option>
          <option value="Google">Google</option>
          <option value="Facebook">Facebook</option>
          <option value="Twitter">Twitter</option>
          <option value="LinkedIn">LinkedIn</option>
          <option value="Friends">Friends</option>
          <option value="Classifieds/Ads">Classifieds/Ads</option>
          <option value="Other">Other</option>
        </select>
      </td>
    </tr>
  </table>
  <br class="clearfix"/>
</div>

<div class="box col1">
  <h2 class="h2c">&nbsp;</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">Comment</td>
      <td class="sep">:</td>
      <td><textarea name="txtComment" id="txtComment"  class="in" rows="2"><?php __e($_POST['txtComment']);?></textarea></td>
    </tr>
  </table>
  <br class="clearfix"/>
</div>

 <div class="box col2">
  <h2 class="h2c">&nbsp;</h2>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="hd">Course Interested</td>
      <td class="sep">:</td>
      <td><textarea name="txtCrInt" id="txtCrInt"  class="in" rows="2"><?php __e($_POST['txtCrInt']);?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="right" class="btpad">
        <input type="submit" name="btnSub" id="btnSub" class="bt" value="Submit now"/>&nbsp;or&nbsp;
        <input type="reset" name="btnCancel" id="btnCancel" class="can" value="Cancel" />
      </td>
    </tr>
  </table>
  <br class="clearfix"/>
</div> 
</form>  