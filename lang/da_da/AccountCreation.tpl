<p>{$To},</p>

<p>En ny bruger har oprettet sig i {$AppTitle} med disse informationer:<br/>
E-mail: {$EmailAddress}<br/>
Navn: {$FullName}<br/>
Telefon: {$Phone}<br/>
Organisation: {$Organization}<br/>
Adresse: {$Position}</p>
{if !empty($CreatedBy)}
	Oprettet af: {$CreatedBy}
{/if}
