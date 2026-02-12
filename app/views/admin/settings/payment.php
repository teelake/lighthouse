<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/settings/general">← General</a><h1>Payment Settings</h1>
<form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/settings/payment">
PayPal Email: <input name="paypal_email" value="<?= htmlspecialchars($paypal_email ?? 'give@thelighthouseglobal.org') ?>"><br>
Stripe Public Key: <input name="stripe_public_key" value="<?= htmlspecialchars($stripe_public ?? '') ?>" placeholder="pk_..."><br>
Stripe Secret Key: <input name="stripe_secret_key" type="password" value="<?= htmlspecialchars($stripe_secret ?? '') ?>" placeholder="sk_..."><br>
<button type="submit">Save</button>
</form>
</body></html>
