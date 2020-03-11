<div class="alert alert-warning">
<h5><i class="icon fas fa-exclamation-triangle"></i> Not Eligible</h5>
Sorry, your last donation was on <strong>{{ date('d F Y', strtotime($availability['last_donated_on'])) }}</strong>.<br>You should not donate before <strong>{{ date('d F Y', strtotime($availability['next_available'])) }}</strong>.
</div>