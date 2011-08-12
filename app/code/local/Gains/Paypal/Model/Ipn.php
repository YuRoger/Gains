<?php
class Gains_Paypal_Model_Ipn extends Mage_Paypal_Model_Ipn
{
	protected function _registerPaymentCapture()
	{
		if ($this->getRequestData ( 'transaction_entity' ) == 'auth')
		{
			return;
		}
		$this->_importPaymentInformation ();
		$payment = $this->_order->getPayment ();
		$payment->setTransactionId ( $this->getRequestData ( 'txn_id' ) )->setPreparedMessage ( $this->_createIpnComment ( '' ) )->setParentTransactionId ( $this->getRequestData ( 'parent_txn_id' ) )->setShouldCloseParentTransaction ( 'Completed' === $this->getRequestData ( 'auth_status' ) )->setIsTransactionClosed ( 0 )->registerCaptureNotification ( $this->getRequestData ( 'mc_gross' ) );
		$this->_order->save ();
		
		//send the invoice out
		$_invoicecollection = $this->_order->getInvoiceCollection ();
		if (sizeof ( $_invoicecollection ) > 0)
		{
			foreach ( $_invoicecollection as $_invoice )
			{
				$_invoice->sendEmail ();
				break;
			}
		}
		// notify customer
		if ($invoice = $payment->getCreatedInvoice () && ! $this->_order->getEmailSent ())
		{
			$comment = $this->_order->sendNewOrderEmail ()->addStatusHistoryComment ( Mage::helper ( 'paypal' )->__ ( 'Notified customer about invoice #%s.', $invoice->getIncrementId () ) )->setIsCustomerNotified ( true )->save ();
		}
	}
}