<p>{$To},</p>

<p>Si è registrato un nuovo utente con le seguenti informazioni:<br />
Email: {$EmailAddress}<br />
Nome: {$FullName}<br />
Telefono: {$Phone}<br />
Area: {$Organization}<br />
Posizione: {$Position}</p>

{if !empty($CreatedBy)}
	Creato da: {$CreatedBy}
{/if}
