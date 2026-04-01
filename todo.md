busca instituicao inscricao estagiario

editar nascimento yymmdd para ddmmyy

pdf 
= alunos =
Declaração de periodo do aluno - aluno/certificadoperiodo aluno/declaracaoperiodo

= estagiarios =
Avaliação do estagiario aluno/avaliacaoimprime avaliacao/imprimeavaliacao estagiario/avaliacaodiscente
Folha de ativiades do estagiario - aluno/folhadeatividades estagiario/folhadeatividades folhadeatividades/folhadeatividades
Declaração de estágio curricular - estagiario/declaracaodeestagio
Termo de compromisso de estagio - estagiario/termodecompromisso

bake model -> avaliacao_notas [ruim regular bom excelente s/a]
bake model -> resposta (instituicao-fimdesemana, mural-convenio) [sim nao parcialmente s/a]
bake model -> mural-formaselecao) [entrevista prova cr outra]

declaracoes - como funciona a folha de atividades?
carga horaria?

- add to menu navegacao:
areas
avaliacoes
dias *
disciplinas *
folhadeatividades
horarios *
historico_professor *
nucleos_de_pesquisa *
situacoes *
turmas
universidades *
visitas


- controllers:

alunos
avaliacoes
estagiarios
folhadeatividades
inscricoes
muralestagios

- policies:

avaliacoes
folhadeatividades
muralestagios

- others

add ligess logo footer
front end sanitize
paginate contain https://stackoverflow.com/questions/43901181/how-to-paginate-associated-records

1. Estudantes, em cada contato, sempre informem NOME COMPLETO e DRE, assim como mantenham em anexo os documentos para análise.
2. Consulte as Recomendações de Estágio para 2024.1? Disponível em: https://ess.ufrj.br/index.php/estagio/areas-otp-estagio
3. Vagas de estágio? Acesse o Mural de Estágios com regularidade.

4. Retirou seu Termo de Compromisso deste semestre? Retire no Mural, logo após aprovação no estágio, e devolva por e-mail preenchido e assinado. A Coordenação assina por último.

5. Precisa de algum formulário? (Mudança de campo, Folha de Atividades, Avaliação Final, etc.) Acesse: ESS/Estágio/Formulários

old fix inscricoes murals view
<input type="hidden" name="data[Inscricao][id_aluno]" value="" id="InscricaoIdAluno">
