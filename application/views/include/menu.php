
<?php if(CheckPermission("Expenses", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="expenses")?"active":"not-active"?>">
						<a href="<?php echo base_url("expenses"); ?>" data-crud_id="31" class="EditCrud"><i class="glyphicon glyphicon-credit-card"></i> <span><?php echo lang('expenses'); ?></span></a>
					</li><?php }?>
<?php if(CheckPermission("Income", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="income")?"active":"not-active"?>">
						<a href="<?php echo base_url("income"); ?>" data-crud_id="32" class="EditCrud"><i class="glyphicon glyphicon-usd"></i> <span><?php echo lang('income'); ?></span></a>
					</li><?php }?>
<?php if(CheckPermission("Expense Category", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="expense_category")?"active":"not-active"?>">
						<a href="<?php echo base_url("expense_category"); ?>" data-crud_id="33" class="EditCrud"><i class="glyphicon glyphicon-align-left"></i> <span><?php echo lang('expense_category'); ?></span></a>
					</li><?php }?>
<?php if(CheckPermission("Income Category", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="income_category")?"active":"not-active"?>">
						<a href="<?php echo base_url("income_category"); ?>" data-crud_id="34" class="EditCrud"><i class="glyphicon glyphicon-align-right"></i> <span><?php echo lang('income_category'); ?></span></a>
					</li><?php }?>
<?php if(CheckPermission("Client Management", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="client_management")?"active":"not-active"?>">
						<a href="<?php echo base_url("client_management"); ?>" data-crud_id="34" class="EditCrud"><i class="glyphicon glyphicon-align-right"></i> <span><?php echo lang('client_management'); ?></span></a>
					</li>
                   <?php }?>
<?php if(CheckPermission("Invoice", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="invoice")?"active":"not-active"?>">
						<a href="<?php echo base_url("invoice"); ?>" data-crud_id="32" class="EditCrud"><i class="glyphicon glyphicon-usd"></i> <span><?php echo lang('invoice'); ?></span></a>
					</li><?php }?>