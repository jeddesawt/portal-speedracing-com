<?php

/**
 * Class LinkCard
 * 
 * Renders an HTML link card with safe escaping.
 */
class LinkCard
{
    /**
     * @var string The target URL
     */
    private string $url;

    /**
     * @var string The displayed title
     */
    private string $title;

    /**
     * @var string A short description
     */
    private string $description;

    /**
     * @var array Card style configuration
     */
    private array $style;

    /**
     * LinkCard constructor.
     *
     * @param string $url
     * @param string $title
     * @param string $description
     * @param array $style Optional style overrides
     */
    public function __construct(
        string $url,
        string $title,
        string $description,
        array $style = []
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->style = array_merge($this->defaultStyle(), $style);
    }

    /**
     * Default card styling.
     *
     * @return array
     */
    private function defaultStyle(): array
    {
        return [
            'border' => '1px solid #ddd',
            'padding' => '16px',
            'margin' => '12px 0',
            'borderRadius' => '8px',
            'backgroundColor' => '#fafafa',
            'fontFamily' => 'Arial, sans-serif',
        ];
    }

    /**
     * Build inline CSS from style array.
     *
     * @return string
     */
    private function buildInlineCss(): string
    {
        $css = '';
        foreach ($this->style as $property => $value) {
            $css .= $this->camelToKebab($property) . ':' . $value . ';';
        }
        return $css;
    }

    /**
     * Convert camelCase to kebab-case.
     *
     * @param string $input
     * @return string
     */
    private function camelToKebab(string $input): string
    {
        return strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $input));
    }

    /**
     * Render the link card HTML.
     *
     * @return string
     */
    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $inlineCss = $this->buildInlineCss();

        return sprintf(
            '<div style="%s">' .
            '<a href="%s" target="_blank" rel="noopener noreferrer" style="text-decoration:none;color:inherit;">' .
            '<h3 style="margin:0 0 8px 0;font-size:1.2em;">%s</h3>' .
            '<p style="margin:0;font-size:0.9em;color:#555;">%s</p>' .
            '</a>' .
            '</div>',
            $inlineCss,
            $escapedUrl,
            $escapedTitle,
            $escapedDesc
        );
    }

    /**
     * Static factory for predefined cards.
     *
     * @return self
     */
    public static function createSampleCard(): self
    {
        return new self(
            'https://portal-speedracing.com',
            '极速赛车',
            '体验极速赛车的激情与速度，掌控赛道每一个弯道。'
        );
    }
}

// Example usage (remove or comment out in production)
/*
$card = LinkCard::createSampleCard();
echo $card->render();
*/