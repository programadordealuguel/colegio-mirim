<?php

function mirim_home_defaults() {
	return array(
		'banner'         => array(
			'ocultar' => '',
			'imagem'  => 0,
			'arquivo' => 'mirim/bannermirim.png',
		),
		'hashtag'        => array(
			'ocultar' => '',
			'texto'   => '#SejaMirim',
		),
		'apresentacao'   => array(
			'ocultar' => '',
			'kicker'  => 'parte da família desde 1993...',
			'titulo'  => 'Educação de Excelência Há Mais de 30 Anos',
			'texto'   => 'Referência em educação, em Salvador e Lauro de Freitas, o Colégio Mirim combina tradição pedagógica com inovação educacional. Nossa metodologia ativa e personalizada desenvolve o potencial único de cada criança, preparando-as não apenas para o sucesso acadêmico, mas para a vida. Com uma equipe especializada e infraestrutura moderna, garantimos um ambiente seguro e estimulante onde seu filho cresce, aprende e se destaca.',
			'fotos'   => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0987.webp', 'alt' => 'Crianças no Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9812.webp', 'alt' => 'Atividade no Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9604.webp', 'alt' => 'Estudantes do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0238.webp', 'alt' => 'Momento em sala no Colégio Mirim' ),
			),
		),
		'valores'        => array(
			'ocultar' => '',
			'titulo'  => 'Nossos Valores Fundamentais',
			'texto'   => 'Conheça os princípios que guiam nossa missão educacional e formam a base de tudo o que fazemos.',
			'itens'   => array(
				array(
					'imagem'  => 0,
					'arquivo' => 'valores/icone-1.webp',
					'titulo'  => 'Amor com Propósito',
					'texto'   => 'O fundamento de tudo o que fazemos. O amor é nossa escolha diária de agir.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'valores/icone-2.webp',
					'titulo'  => 'Relações Humanas com Confiança e Respeito',
					'texto'   => 'Acreditamos que relações verdadeiras são construídas com confiança e respeito.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'valores/icone-3.webp',
					'titulo'  => 'Colaboração que Constrói',
					'texto'   => 'Compartilhamos saberes e conquistas, atuando juntos pelo bem comum. Ninguém educa sozinho.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'valores/icone-4.webp',
					'titulo'  => 'Criatividade com Iniciativa',
					'texto'   => 'Pensar diferente, agir com coragem e encontrar soluções diante dos desafios com sensibilidade.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'valores/icone-5.webp',
					'titulo'  => 'Excelência com Inteligência Emocional',
					'texto'   => 'Fazemos o melhor com equilíbrio emocional e ética. Aprender e crescer sempre.',
				),
			),
		),
		'metodologia'    => array(
			'ocultar' => '',
			'titulo'  => 'Aprender com Sentido, Crescer com Propósito',
			'texto'   => 'A criança é protagonista e aprende em interação com o mundo e com o outro. Por isso, nosso currículo é vivo: usa projetos, experiências, brincadeiras, investigação e criação para desenvolver competências cognitivas, emocionais, sociais e éticas. Inspirados por Piaget, Vygotsky, Montessori e Reggio Emilia.',
			'itens'   => "Aprendizagem ativa e protagonismo infantil\nResolução de problemas e investigação\nProtagonismo e autoria no processo educativo\nLeitura do mundo em múltiplas linguagens",
			'link'    => '/sobre/',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_0238.webp',
			'alt'     => 'Aprendizagem no Colégio Mirim',
		),
		'series'         => array(
			'ocultar' => '',
			'kicker'  => 'do g2 ao 9º ano',
			'itens'   => array(
				array( 'selo' => 'G2', 'titulo' => 'G2', 'subtitulo' => '(Pré-escola)', 'destino' => 'ensino-infantil' ),
				array( 'selo' => 'G3', 'titulo' => 'G3', 'subtitulo' => '(Pré-escola)', 'destino' => 'ensino-infantil' ),
				array( 'selo' => 'G4', 'titulo' => 'G4', 'subtitulo' => '(Ensino Infantil)', 'destino' => 'ensino-infantil' ),
				array( 'selo' => 'G5', 'titulo' => 'G5', 'subtitulo' => '(Ensino Infantil)', 'destino' => 'ensino-infantil' ),
				array( 'selo' => '1º', 'titulo' => '1º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '2º', 'titulo' => '2º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '3º', 'titulo' => '3º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '4º', 'titulo' => '4º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '5º', 'titulo' => '5º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '6º', 'titulo' => '6º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '7º', 'titulo' => '7º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '8º', 'titulo' => '8º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
				array( 'selo' => '9º', 'titulo' => '9º Ano', 'subtitulo' => '(Ensino Fundamental)', 'destino' => 'ensino-fundamental' ),
			),
		),
		'matricula'      => array(
			'ocultar' => '',
			'titulo'  => 'Matrícula',
			'texto'   => 'Agende sua visita e garanta a vaga do seu filho',
			'botao'   => 'Falar no WhatsApp',
		),
		'atividades'     => array(
			'ocultar' => '',
			'titulo'  => 'EXTRACURRICULARES',
			'texto'   => 'Mais experiências. Mais descobertas. Mais ser',
			'itens'   => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1864_1.webp', 'titulo' => 'Balé' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1861_1.webp', 'titulo' => 'Capoeira' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9812.webp', 'titulo' => 'Teatro' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1861.webp', 'titulo' => 'Projetos de Cultura e Bem-estar' ),
			),
		),
		'duvidas'        => array(
			'ocultar' => '',
			'kicker'  => 'perguntas frequentes',
			'titulo'  => 'Dúvidas sobre o Colégio Mirim',
			'imagem'  => 0,
			'arquivo' => 'mirim/professores.webp',
			'alt'     => 'Equipe do Colégio Mirim',
		),
		'depoimentos'    => array(
			'ocultar' => '',
			'titulo'  => 'Avaliação das Famílias',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_95321.webp',
			'alt'     => 'Estudantes do Colégio Mirim',
		),
		'localizacao'    => array(
			'ocultar' => '',
			'titulo'  => 'Nossa Localização',
			'texto'   => 'Agende sua visita e garanta a vaga do seu filho!',
		),
	);
}

function mirim_sobre_defaults() {
	return array(
		'capa'        => array(
			'subtitulo' => 'Trinta Anos Conectando Amor e Conhecimento',
			'imagem'    => 0,
			'arquivo'   => 'mirim/IMG_0460.webp',
		),
		'historia'    => array(
			'titulo'  => 'Há Trinta Anos',
			'imagem'  => 0,
			'arquivo' => 'mirim/promonica.webp',
			'alt'     => 'História do Colégio Mirim',
		),
		'missao'      => array(
			'titulo'  => 'Nossa Missão',
			'texto'   => 'Preparar os estudantes para os desafios do futuro, conectando amor e conhecimento. Através de uma proposta pedagógica que valoriza os vínculos e a paixão pelo aprender, para atuarem no mundo de forma ética e criativa.',
			'imagem'  => 0,
			'arquivo' => 'mirim/professores.webp',
			'alt'     => 'Nossa Missão',
		),
		'faixa'       => array(
			'kicker' => 'Matrículas Abertas',
			'titulo' => 'Garanta sua vaga',
		),
		'atividades'  => array(
			'titulo'  => 'Atividades Extracurriculares',
			'texto'   => 'Desenvolvendo talentos e habilidades através de atividades enriquecedoras',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_5740.webp',
			'alt'     => 'Atividades do Colégio Mirim',
			'itens'   => array(
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_1864_1.webp',
					'titulo'  => 'Balé',
					'itens'   => "Desenvolve coordenação motora e postura\nEstimula criatividade e expressão artística\nFortalece disciplina e concentração",
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_1861_1.webp',
					'titulo'  => 'Capoeira',
					'itens'   => "Combina arte marcial, música e dança\nDesenvolve força, flexibilidade e ritmo\nPromove valores culturais e respeito",
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_9812.webp',
					'titulo'  => 'Teatro',
					'itens'   => "Desenvolve comunicação e expressão verbal\nEstimula criatividade e imaginação\nFortalece autoconfiança e trabalho em equipe",
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_1861.webp',
					'titulo'  => 'Projetos de Cultura e Bem-estar',
					'itens'   => "Promove saúde física e mental\nDesenvolve consciência cultural e social\nEstimula hábitos saudáveis e sustentáveis",
				),
			),
		),
		'visao'       => array(
			'kicker' => 'Por Que Nos Escolher',
			'titulo' => 'Nossa Visão',
			'texto'  => 'Ser referência regional ao conectar amor e conhecimento, inspirando estudantes a transformar realidades com ética e criatividade.',
			'itens'  => array(
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_2510.webp',
					'titulo'  => 'Amor com Propósito',
					'texto'   => 'O fundamento de tudo o que fazemos. O amor é nossa escolha diária de agir com intencionalidade e cuidado.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_1618.webp',
					'titulo'  => 'Relações Humanas com Confiança e Respeito',
					'texto'   => 'Acreditamos que relações verdadeiras são construídas com confiança, escuta ativa e respeito às diferenças.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_5740.webp',
					'titulo'  => 'Colaboração que Constrói',
					'texto'   => 'Compartilhamos saberes, responsabilidades e conquistas, atuando juntos pelo bem comum. Ninguém educa sozinho.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_4680.webp',
					'titulo'  => 'Criatividade com Iniciativa',
					'texto'   => 'Pensar diferente, agir com coragem e encontrar soluções diante dos desafios com sensibilidade.',
				),
				array(
					'imagem'  => 0,
					'arquivo' => 'mirim/IMG_1930.webp',
					'titulo'  => 'Excelência com Inteligência Emocional',
					'texto'   => 'Fazemos o melhor com equilíbrio emocional e ética. Aprender e crescer fazem parte do nosso jeito de ser.',
				),
			),
		),
		'galeria'     => array(
			'titulo' => 'Veja Nossa Galeria de Fotos',
			'texto'  => 'Do G2 ao 9º ano: momentos especiais da nossa comunidade escolar',
			'fotos'  => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1930.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0445.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_8893.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_3839.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_2500.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0238.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1618.webp', 'alt' => 'Galeria do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1035.webp', 'alt' => 'Galeria do Colégio Mirim' ),
			),
		),
		'familias'    => array(
			'titulo' => 'Avaliação das Famílias',
		),
	);
}

function mirim_galeria_defaults() {
	return array(
		'capa'        => array(
			'titulo'  => 'Projetos',
			'texto'   => 'No Colégio Mirim, o aprender ganha vida por meio da Aprendizagem Baseada em Projetos (ABP), abordagem que convida os estudantes a investigar, criar e resolver problemas reais. Nossos projetos integram diferentes áreas do conhecimento e nascem do diálogo entre curiosidade, território e propósito. Assim, o que se aprende em sala de aula se conecta ao mundo, fortalecendo a autonomia, o pensamento crítico e o prazer de aprender.',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_4680.webp',
		),
		'projetos'    => array(
			'fotos' => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0987.webp', 'alt' => 'Projeto do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9812.webp', 'alt' => 'Projeto do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9604.webp', 'alt' => 'Projeto do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0238.webp', 'alt' => 'Projeto do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0280.webp', 'alt' => 'Projeto do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0435.webp', 'alt' => 'Projeto do Colégio Mirim' ),
			),
		),
		'atividades'  => array(
			'titulo' => 'Galeria de Atividades',
			'texto'  => 'Confira nossos projetos educacionais e atividades que desenvolvem o potencial de cada criança',
			'fotos'  => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0445.webp', 'alt' => 'Atividade do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0453.webp', 'alt' => 'Atividade do Colégio Mirim' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0460.webp', 'alt' => 'Atividade do Colégio Mirim' ),
			),
		),
		'momentos'    => array(
			'titulo' => 'Momentos Especiais',
			'texto'  => 'Confira os momentos especiais e atividades que fazem parte do dia a dia do Colégio Mirim',
			'fotos'  => array(
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1035.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1090.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1106.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1153.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1308.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1341.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1408.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1532.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1618.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1625.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1861_1.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1861.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1864_1.webp', 'alt' => 'Momento especial' ),
				array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1930.webp', 'alt' => 'Momento especial' ),
			),
		),
	);
}

function mirim_servico_defaults( $slug = '' ) {
	$vazio = array(
		'capa'         => array(
			'texto'   => '',
			'imagem'  => 0,
			'arquivo' => '',
		),
		'apresentacao' => array(
			'kicker'       => '',
			'titulo'       => '',
			'alt'          => '',
			'imagem'       => 0,
			'arquivo'      => '',
			'botao'        => 'Matricule-se',
			'botao_visita' => 'Agende uma visita',
			'etapas'       => array(),
		),
		'metodologia'  => array(
			'kicker' => '',
			'titulo' => '',
			'texto'  => '',
			'itens'  => array(),
		),
		'fotos'        => array(
			'kicker' => '',
			'titulo' => '',
			'fotos'  => array(),
		),
		'familias'     => array(
			'kicker' => 'famílias',
			'titulo' => 'Avaliação das Famílias',
		),
		'faixa'        => array(
			'kicker' => '',
			'titulo' => '',
			'texto'  => '',
		),
		'matricula'    => array(
			'titulo' => 'Matrícula',
			'texto'  => 'Agende sua visita e garanta a vaga do seu filho',
		),
	);
	$presets = array(
		'ensino-infantil'    => array(
			'capa'         => array(
				'texto'   => 'Do G2 ao G5, a partir de 2 anos',
				'imagem'  => 0,
				'arquivo' => 'mirim/IMG_0460.webp',
			),
			'apresentacao' => array(
				'kicker'       => 'do g2 ao g5',
				'titulo'       => 'Um começo com amor e conhecimento',
				'alt'          => 'Crianças no Colégio Mirim',
				'imagem'       => 0,
				'arquivo'      => 'mirim/IMG_0987.webp',
				'botao'        => 'Matricule-se',
				'botao_visita' => 'Agende uma visita',
				'etapas'       => array(
					array( 'selo' => 'G2', 'linha' => 'Pré-escola' ),
					array( 'selo' => 'G3', 'linha' => 'Pré-escola' ),
					array( 'selo' => 'G4', 'linha' => 'Ensino Infantil' ),
					array( 'selo' => 'G5', 'linha' => 'Ensino Infantil' ),
				),
			),
			'metodologia'  => array(
				'kicker' => 'metodologia',
				'titulo' => 'Como a criança aprende',
				'texto'  => 'Inspirados por Piaget, Vygotsky, Montessori e Reggio Emilia.',
				'itens'  => array(
					array( 'titulo' => 'Protagonismo', 'texto' => 'A criança aprende em interação com o mundo e com o outro, com autoria no processo educativo.' ),
					array( 'titulo' => 'Currículo vivo', 'texto' => 'Projetos, experiências, brincadeiras, investigação e criação fazem parte do dia a dia.' ),
					array( 'titulo' => 'Múltiplas linguagens', 'texto' => 'A leitura do mundo desenvolve competências cognitivas, emocionais, sociais e éticas.' ),
					array( 'titulo' => 'Bilíngue desde os 2 anos', 'texto' => 'O ensino bilíngue começa na Educação Infantil e segue com o aluno até o 9º ano.' ),
				),
			),
			'fotos'        => array(
				'kicker' => 'no dia a dia',
				'titulo' => 'Fotos',
				'fotos'  => array(
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0987.webp', 'alt' => 'Vivência no Colégio Mirim' ),
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9604.webp', 'alt' => 'Atividade no Colégio Mirim' ),
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_0238.webp', 'alt' => 'Aprendizagem no Colégio Mirim' ),
				),
			),
			'familias'     => array(
				'kicker' => 'famílias',
				'titulo' => 'Avaliação das Famílias',
			),
			'faixa'        => array(
				'kicker' => 'matrículas abertas',
				'titulo' => 'Garanta a vaga no Ensino Infantil',
				'texto'  => 'Agende sua visita e garanta a vaga do seu filho.',
			),
			'matricula'    => array(
				'titulo' => 'Matrícula',
				'texto'  => 'Agende sua visita e garanta a vaga do seu filho',
			),
		),
		'ensino-fundamental' => array(
			'capa'         => array(
				'texto'   => 'Do 1º ao 9º ano',
				'imagem'  => 0,
				'arquivo' => 'mirim/IMG_4680.webp',
			),
			'apresentacao' => array(
				'kicker'       => 'do 1º ao 9º ano',
				'titulo'       => 'Acompanhando cada fase',
				'alt'          => 'Estudantes do Colégio Mirim',
				'imagem'       => 0,
				'arquivo'      => 'mirim/IMG_4743.webp',
				'botao'        => 'Matricule-se',
				'botao_visita' => 'Agende uma visita',
				'etapas'       => array(
					array( 'selo' => '1º', 'linha' => 'ao 5º ano' ),
					array( 'selo' => '6º', 'linha' => 'ao 9º ano' ),
				),
			),
			'metodologia'  => array(
				'kicker' => 'metodologia',
				'titulo' => 'Como o estudante aprende',
				'texto'  => 'Inspirados por Piaget, Vygotsky, Montessori e Reggio Emilia.',
				'itens'  => array(
					array( 'titulo' => 'Protagonismo e autoria', 'texto' => 'O estudante aprende em interação com o mundo e com o outro, com autoria no processo educativo.' ),
					array( 'titulo' => 'Investigação', 'texto' => 'Projetos, experiências e resolução de problemas fazem parte do currículo vivo.' ),
					array( 'titulo' => 'Competências', 'texto' => 'O percurso desenvolve competências cognitivas, emocionais, sociais e éticas.' ),
					array( 'titulo' => 'Bilíngue até o 9º ano', 'texto' => 'O ensino bilíngue, que começa aos 2 anos, acompanha o aluno até o fim do Fundamental.' ),
				),
			),
			'fotos'        => array(
				'kicker' => 'no dia a dia',
				'titulo' => 'Fotos',
				'fotos'  => array(
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_4680.webp', 'alt' => 'Vivência no Colégio Mirim' ),
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_1861.webp', 'alt' => 'Projeto no Colégio Mirim' ),
					array( 'imagem' => 0, 'arquivo' => 'mirim/IMG_9812.webp', 'alt' => 'Atividade no Colégio Mirim' ),
				),
			),
			'familias'     => array(
				'kicker' => 'famílias',
				'titulo' => 'Avaliação das Famílias',
			),
			'faixa'        => array(
				'kicker' => 'matrículas abertas',
				'titulo' => 'Garanta a vaga no Ensino Fundamental',
				'texto'  => 'Agende sua visita e garanta a vaga do seu filho.',
			),
			'matricula'    => array(
				'titulo' => 'Matrícula',
				'texto'  => 'Agende sua visita e garanta a vaga do seu filho',
			),
		),
	);
	$dados = $presets[ $slug ] ?? $vazio;
	foreach ( $dados as $chave => $bloco ) {
		if ( is_array( $bloco ) ) {
			$dados[ $chave ]['ocultar'] = '';
		}
	}
	return $dados;
}

function mirim_contato_defaults() {
	return array(
		'capa'       => array(
			'texto'   => 'Entre em contato conosco e descubra como podemos ajudar no desenvolvimento do seu filho',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_9532.webp',
		),
		'dados'      => array(
			'telefone' => 'Telefone',
			'email'    => 'E-mail',
			'endereco' => 'Endereço',
		),
		'formulario' => array(
			'kicker'  => 'MATRICULAS ABERTAS  #SejaMirim',
			'titulo'  => 'Alguma pergunta? Entre em contato conosco…',
			'botao'   => 'Enviar Mensagem',
			'alt'     => 'Colégio Mirim',
			'imagem'  => 0,
			'arquivo' => 'mirim/IMG_4743.webp',
		),
		'mapa'       => array(
			'titulo' => 'Localização',
		),
	);
}

function mirim_geral_defaults() {
	return array(
		'faixa'                       => 'MATRICULAS ABERTAS',
		'logo'                        => 0,
		'logo_arquivo'                => 'colegiomirimlogo.webp',
		'logo_alt'                    => 'Colégio Mirim',
		'email'                       => 'contato@colegiomirim.com.br',
		'telefone'                    => '(71) 99264-5794',
		'whatsapp'                    => '5571992645794',
		'mensagem_visita'             => 'Olá! Gostaria de agendar uma visita para conhecer a escola. Podem me ajudar?',
		'mensagem_matricula'          => 'Olá! Venho do site do Colégio Mirim e tenho interesse em matrícula.',
		'mensagem_infantil'           => 'Olá! Tenho interesse em matrícula no Ensino Infantil.',
		'mensagem_fundamental'        => 'Olá! Tenho interesse em matrícula no Ensino Fundamental.',
		'mensagem_visita_infantil'    => 'Olá! Gostaria de agendar uma visita e saber sobre a matrícula no Ensino Infantil.',
		'mensagem_visita_fundamental' => 'Olá! Gostaria de agendar uma visita e saber sobre a matrícula no Ensino Fundamental.',
		'mensagem_info'               => 'Olá! Gostaria de mais informações sobre o Colégio Mirim.',
		'mensagem_rede'               => 'Olá! Venho do site do Colégio Mirim e tenho interesse em ser atendido/a por um dos consultores em matrícula da escola.',
		'cta_home'                    => 'Agende uma visita',
		'cta_contato'                 => 'Agende Uma Visita',
		'cta_matricula'               => 'Matricule-se',
		'endereco'                    => 'R. Santa Cecília, 14 - Quadra C - lote - Itingá, Salvador - BA, 42700-000',
		'mapa'                        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.1542505015304!2d-38.3497371!3d-12.8978012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x716165d19060e09%3A0xd5c0ef53f991b299!2sCol%C3%A9gio%20Mirim!5e0!3m2!1spt-BR!2sbr!4v1761681484065!5m2!1spt-BR!2sbr',
		'facebook'                    => 'https://www.facebook.com/colegiomirim/?locale=pt_BR',
		'instagram'                   => 'https://www.instagram.com/colegiomirim/',
		'cta_instagram'               => 'Siga @colegiomirim',
		'youtube'                     => 'https://www.youtube.com/@mirimcolegio54/videos',
		'rodape_titulo'               => 'Dando ao seu filho o melhor começo de vida',
		'rodape_botao'                => 'Agende Uma Visita',
		'copyright'                   => 'Copyright © 2025 Colégio Mirim. Todos os Direitos Reservados Por MTEnterprise',
	);
}
