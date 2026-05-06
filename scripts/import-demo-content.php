<?php
/**
 * Executa importação do conteúdo demo via WP-CLI.
 *
 * Uso:
 * wp eval-file wp-content/themes/xxx-safety-prevention/scripts/import-demo-content.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Este script deve ser executado dentro do WordPress (WP-CLI).\n" );
}

$importer_file = get_template_directory() . '/inc/demo-importer.php';

if ( ! file_exists( $importer_file ) ) {
	exit( "Arquivo do importador não encontrado: {$importer_file}\n" );
}

require_once $importer_file;

if ( ! function_exists( 'xxx_import_demo_content' ) ) {
	exit( "Função xxx_import_demo_content() não encontrada.\n" );
}

$report = xxx_import_demo_content();

echo "=== Relatório de Importação Demo ===\n";
echo 'Páginas criadas: ' . (int) $report['pages_created'] . "\n";
echo 'Páginas atualizadas: ' . (int) $report['pages_updated'] . "\n";
echo 'Produtos criados: ' . (int) $report['products_created'] . "\n";
echo 'Produtos atualizados: ' . (int) $report['products_updated'] . "\n";
echo 'FAQ criadas: ' . (int) $report['faq_created'] . "\n";
echo 'FAQ atualizadas: ' . (int) $report['faq_updated'] . "\n";
echo 'Depoimentos criados: ' . (int) $report['testimonials_created'] . "\n";
echo 'Depoimentos atualizados: ' . (int) $report['testimonials_updated'] . "\n";

if ( ! empty( $report['warnings'] ) ) {
	echo "Avisos:\n";
	foreach ( $report['warnings'] as $warning ) {
		echo '- ' . $warning . "\n";
	}
}

if ( ! empty( $report['errors'] ) ) {
	echo "Erros:\n";
	foreach ( $report['errors'] as $error ) {
		echo '- ' . $error . "\n";
	}
	exit( 1 );
}

echo "Importação concluída com sucesso.\n";
