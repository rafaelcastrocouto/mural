<?php

$logo = $this->Html->image('logoess_horizontal.svg', array('alt' => 'ESS', 'width' => '200px', 'height' => '50px'));
// echo $logo;

// setlocale (LC_TIME, 'pt_BR');
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

// echo $termoinicio . "<br>";
// print_r($estudante);
// die('avaliacaoimprime');

$texto = <<<EOD

<h2 style="text-align:center">
$logo
Coordenação de Estágio<br />
Avaliação final do(a) supervisor(a) de campo do desempenho discente
</h2>

<p style="line-height:100%; font-size: 90%">
Nome do(a) Estudante: $estudante<br>
Supervisor(a) de Campo: $supervisor CRESS: $cress <br />
E-mail: $email Telefone: $telefone Celular: $celular<br />
Campo de Estágio: $instituicao<br />
Endereço Institucional: $endereco_inst<br />
Período de realização do estágio: $periodo<br />
Nível de Estágio: $nivel<br />
Supervisor(a) Acadêmico(a): $professor
</p>

<p>
<b>Leia atentamente cada item e marque um X na posição que melhor descreva os resultados alcançados com a inserção do(a) aluno(a) no campo de estágio.</b>
</p>

<table style="width: 100%">
                <tr style="vertical-align:middle;">
                    <td style="width: 72%">
                        Inserção e desenvolvimento do(a) Aluno(a) no Espaço Sócio institucional/ocupacional
                    </td>
                    <td></td>
                </tr>
        
                <tr>
                    <td>
                        1 - ASSIDUIDADE: É freqüênte, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        2 - PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        3 - COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        4 - Na relação com o(a) usuário(a): compromisso ético-político no atendimento direto ao usuário(a).
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        5 - Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        6 - CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        7- Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>
                        8 - Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

</table>

<p style="line-height: 1">
9) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
<br style="line-height: 100%;">
(   ) sim   (   ) não. Fundamente se achar necessário: 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas  condições de trabalho do campo de estágio?
<br>
(   ) sim   (   ) não. Justifique a resposta se achar necessário. 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
11) Quanto à integração Universidade / campo de estágio: Há discussão conjunta do trabalho entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?
<br>
(   ) sim   (   ) não. Justifique a resposta se achar necessário. 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
Se a resposta foi não. Como poderia ser desenvolvida _________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
12) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
<br>
(   ) sim   (   ) não. Quais?
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
Sugestões e observações:
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
</p>

<br>
<br>
<p>
<span style="text-align: right">Rio de Janeiro, $dia de $mes de $ano.</span>
</p>

<table>
<tr>
<td>Coordenação de Estágio e Extensão</td>
<td>$estudante <br> (DRE: $registro)</td>
<td>$supervisor <br> (CRESS 7ª Região: $cress)</td>
</tr>

</table>
EOD;

// pr($texto);
echo $this->Html->link(__("Imprime PDF"), array("action" => "avaliacaoimprimepdf", "?" => ['registro' => $registro], 'ext' => 'pdf', $registro));

?>
