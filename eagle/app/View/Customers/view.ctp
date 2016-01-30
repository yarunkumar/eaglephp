<div class="related">
<?php
$stock_purchase_value=0;
$stock_current_value=0;
$investment_acquired_value=0;
$investment_recent_value=0;
$portfolio_stock =0;
$portfolio_investment =0;
$originavalue = 0;
?>
<h2><?php echo __('Customer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Streetaddress'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['streetaddress']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Primaryemail'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['primaryemail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homephone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['homephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cellphone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['cellphone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h2><?php echo __('Investments'); ?></h2>
	<?php if (!empty($customer['Investment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Category'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Acquired Value'); ?></th>
		<th><?php echo __('Acquired Date'); ?></th>
		<th><?php echo __('Recent Value'); ?></th>
		<th><?php echo __('Recent Date'); ?></th>
	</tr>
	<?php foreach ($customer['Investment'] as $investment): ?>
		<tr>
			<td><?php echo $investment['category']; ?></td>
			<td><?php echo $investment['description']; ?></td>
			<td><?php echo $investment['acquiredvalue']; ?></td>
			<?php $investment_acquired_value = $investment_acquired_value + $investment['acquiredvalue'] ?>
			<td><?php echo $investment['acquireddate']; ?></td>
			<td><?php echo $investment['recentvalue']; ?></td>
			<?php $investment_recent_value = $investment_recent_value + $investment['recentvalue'] ?>
			<td><?php echo $investment['recentdate']; ?></td>
		</tr>
	<?php endforeach; ?>
		<tr>
<td></td>
<td></td>
<td><b>$ <?php echo $investment_acquired_value ?></b></td>
<td></td>
<td><b>$ <?php echo  $investment_recent_value ?></b></td>
<td></td>
    		</tr>
	</table>
<?php endif; ?>
</div>


<div class="related">
	<h2><?php echo __('Stocks'); ?></h2>
	<?php if (!empty($customer['Stock'])):?>
	<table cellpadding = "0" cellspacing = "0">

	<tr>
		<th><?php echo __('Stock Symbol'); ?></th>
		<th><?php echo __('No. Shares'); ?></th>
		<th><?php echo __('Purchase Price'); ?></th>
		<th><?php echo __('Date of Purchase'); ?></th>
		<th><?php echo __('Original Value'); ?></th>
		<th><?php echo __('Current Price'); ?></th>
		<th><?php echo __('Current Value'); ?></th>
	</tr>
	<?php foreach ($customer['Stock'] as $stock):
	require_once('nusoap.php');

    $c = new nusoap_client('http://loki.ist.unomaha.edu/~groyce/ws/stockquoteservice.php');

    $currentprice = $c->call('getStockQuote',
                  array('symbol' => $stock['stsymbol']));
	?>
		<tr>
			<td><?php echo $stock['stsymbol']; ?></td>
			<td><?php echo $stock['noshares']; ?></td>
			<td><?php echo $stock['purchaseprice']; ?></td>
			<td><?php echo $stock['datepurchased']; ?></td>
			<?php $originalvalue = ($stock['purchaseprice'] * $stock['noshares'])?>
			<td><?php echo $originalvalue ?></td>
			<?php $stock_purchase_value = $stock_purchase_value + ($stock['purchaseprice'] * $stock['noshares'] )?>
            <td><?php echo $currentprice; ?></td>
			<td><?php echo $currentprice * $stock['noshares']; ?></td>
			<?php $stock_current_value = $stock_current_value + ($currentprice * $stock['noshares'] )?>
		</tr>
	<?php endforeach; ?>
	<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><b>$ <?php echo $stock_purchase_value ?></b></td>
    <td></td>
    <td><b>$ <?php echo $stock_current_value ?></b></td>
    </tr>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php echo __('Total Portfolio Value'); ?></h2>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Category'); ?></th>
		<th><?php echo __('Original Value'); ?></th>
		<th><?php echo __('Current Value'); ?></th>
	</tr>

		<tr>

			<td><?php echo __ ('Stocks')?></td>
			<td>$<?php echo $stock_purchase_value?></td>
			<td>$<?php echo $stock_current_value?></td>
		</tr>

		<tr>
			<td><?php echo __ ('Investments')?></td>
			<td>$<?php echo $investment_acquired_value?></td>
			<td>$<?php echo $investment_recent_value?></td>
		</tr>

	<?php $portfolio_stock = $stock_purchase_value + $investment_acquired_value  ?>
	<?php $portfolio_investment =  $stock_current_value +  $investment_recent_value ?>
		<tr>
			<td><b><?php echo __ ('Total Portfolio Value')?></b></td>
			<td><b>$ <?php echo $portfolio_stock?></b></td>
			<td><b>$ <?php echo $portfolio_investment?></b></td>
		</tr>
	</table>
</div>
