<?php
dol_include_once('/seven/core/class/seven_logger.class.php');
dol_include_once('/fourn/class/fournisseur.facture.class.php');
dol_include_once('/fourn/class/fournisseur.commande.class.php');
dol_include_once('/contact/class/contact.class.php');
dol_include_once('/seven/core/controllers/seven.controller.php');

class SupplierOrderController extends SevenBaseController {
	var CommandeFournisseur $order;
	var Societe $thirdparty;
	var Seven_Logger $log;

	function __construct($id) {
		global $db;

		$this->log = new Seven_Logger;

		$this->order = new CommandeFournisseur($db);
		$this->order->fetch($id);

		$this->thirdparty = new Societe($db);
		$this->thirdparty->fetch($this->order->socid);

		parent::__construct($id);
	}

	public function render(): void {
		global $langs, $form;
		?>
		<input type='hidden' name='object_id' value='<?= $this->id ?>'/>
		<input type='hidden' name='send_context' value='supplier_order'/>
		<tr>
			<td>
				<?= $form->textwithpicto($langs->trans('SmsTo'), 'The contact mobile you want to send SMS to'); ?>
			</td>
			<td>
				<input type='hidden' name='thirdparty_id' value='<?= $this->thirdparty->id ?>'/>
				<?= $form->select_thirdparty_list($this->thirdparty->id, 'thirdparty_id', '', 0, 0, 0, [], '', 0, 0, '', 'disabled') ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?= $form->selectcontacts($this->thirdparty->id, '', 'sms_contact_ids', 1, '', '', 1, 'width200', false, 0, 0, [], '', '', true) ?>
			</td>
		</tr>
		<?php
	}
}
