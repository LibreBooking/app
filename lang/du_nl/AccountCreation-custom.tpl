<p>{$To},</p>

<p>Een nieuwe gebruiker is geregistreerd met de volgende informatie:<br/>
Email: {$EmailAddress}<br/>
Naam: {$FullName}<br/>
Telefoonnummer: {$Phone}<br/>
Organisatie: {$Organization}<br/>
Positie: {$Position}</p>
{if !empty($CreatedBy)}
	Gemaakt door: {$CreatedBy}
{/if}
