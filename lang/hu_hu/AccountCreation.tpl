<p>{$To},</p>

<p>Egy új felhasználó regisztrált az alábbi információkkal:<br/>
Email: {$EmailAddress}<br/>
Név: {$FullName}<br/>
Telefon: {$Phone}<br/>
Szervezet: {$Organization}<br/>
Pozíció: {$Position}</p>
{if !empty($CreatedBy)}
	Készítette: {$CreatedBy}
{/if}
