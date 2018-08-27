<?php
class AdrUserNewEdit extends Render {

	static public function render ($user, $plans, $phoneComapanies) {
		
		ob_start();

		$disabledLoggin = '';
		$classValidatePassword = ' mandatory-input input-password-validate input-password-length-validate';

		if($user->getUserLogin() != '') {
			$disabledLoggin = 'disabled="disabled"';
			$classValidatePassword = '';
		}

		/* @var $user AdrUser */
		?>	<div class="container" >
		<!-- Example row of columns id="claim-new-edit"-->
		<div class="row">
		<div class="col-md-4">

		</div>
		<div class="col-md-4"  >
		<div >
	  		<form id="adrUserNewEditForm" name="adrUserNewEditForm" method="POST" action="" autocomplete="off">
	  			<div >
		  			<label><?=Util::getLiteral('user_firstname')?>:</label><input type="text" id="firstname" class="form-control" name="firstname" value="<?=$user->getFirstName()?>" />
		  		</div>
		  		<div >
	  				<label><?=Util::getLiteral('user_lastname')?>:</label><input type="text" id="lastname" class="form-control" name="lastname" value="<?=$user->getLastName()?>" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('user_phone_number')?>:</label><input type="text" id="phoneNumber" class="adr-user-input mandatory-input input-number-validate" maxlength="20" name="phoneNumber" value="<?=$user->getPhoneNumber()?>" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('user_phone_company')?>:</label>
  					<select id="phoneCompanyId" class="form-control" name="phoneCompanyId" />
  						<option value=""><?=Util::getLiteral('user_phone_company_select_one')?></option>
  						<?php
  						/* @var $phoneCompany AdrPhoneCompany */
						foreach ($phoneComapanies as $phoneCompany) {
  							$selectedPhoneCompany = '';

  							// FIXME:
							if($phoneCompany->getName() == $user->getPhoneCompany()) {
								$selectedPhoneCompany = 'selected="selected"';
							}
							echo '<option value="'.$phoneCompany->getId().'" '.$selectedPhoneCompany.'>'.$phoneCompany->getName().'</option>';
						}
  						?>
	  				</select>
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('user_loggin')?>:</label><input type="text" id="userLoggin" class="form-control" name="loggin" value="<?=$user->getUserLogin()?>" <?=$disabledLoggin?>/>
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('user_password')?>:</label><input type="password" id="userPassword" class="adr-user-input<?=$classValidatePassword?>" name="password" value="" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('user_confirm_password')?>:</label><input type="password" id="userConfirmPassword" class="adr-user-input<?=$classValidatePassword?>" name="confirmPassword" value="" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('adr_plan_name')?>:</label>
  					<select id="planId" class="form-control" name="planId" />
  						<option value=""><?=Util::getLiteral('adr_plan_name_select_one')?></option>
  						<?php
  						/* @var $plan AdrPlan */
						foreach ($plans as $plan) {
  							$selectedPlan = '';
							if($plan->getId() == $user->getPlanId()) {
								$selectedPlan = 'selected="selected"';
							}
							echo '<option value="'.$plan->getId().'" '.$selectedPlan.'>'.$plan->getName().'</option>';
						}
  						?>
	  				</select>
		  		</div>
		  		<div  style="border-top: 1px solid #a9bdc6;">
		  			<input type="hidden" name="id" value="<?=$user->getId()?>" />
		  			<div onclick="saveUser();" title="<?=Util::getLiteral('user_save')?>" class="btn btn-success"><?=Util::getLiteral('user_save')?></div>
		  			<div onclick="cancelSaveUser();" title="<?=Util::getLiteral('user_cancel_save')?>" class="btn btn-danger"><?=Util::getLiteral('user_cancel_save')?></div>
				</div>
			</form>
		</div>
</div>
		<div class="col-md-4">

		</div>
		</div>
		<?php
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-users.js";
				
		return ob_get_clean();
	}
	
}
?>