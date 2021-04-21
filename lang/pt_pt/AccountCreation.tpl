<p>{$To},</p>

<p>Um novo utilizador registou-se com a seguinte informação:<br/>
Email: {$EmailAddress}<br/>
Nome: {$FullName}<br/>
Telefone: {$Phone}<br/>
Organização: {$Organization}<br/>
Posição: {$Position}</p>
{if !empty($CreatedBy)}
	Criado por: {$CreatedBy}
{/if}
