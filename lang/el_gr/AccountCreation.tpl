<p>{$To},</p>

<p>Ένας νέος χρήστης έκανε εγγραφή με τις παρακάτω πληροφορίες:<br/>
Email: {$EmailAddress}<br/>
Όνομα: {$FullName}<br/>
Τηλέφωνο: {$Phone}<br/>
Οργανισμός: {$Organization}<br/>
Θέση: {$Position}</p>
{if !empty($CreatedBy)}
	Δημιουργήθηκε από: {$CreatedBy}
{/if}
