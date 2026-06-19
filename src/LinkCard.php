<?php

/**
 * 链接卡片渲染器
 * 根据标题、描述、URL和图标生成结构化的HTML卡片
 */
class LinkCard
{
    /**
     * 默认配置
     *
     * @var array
     */
    private array $config = [
        'url'         => 'https://ssl-cn-mahjong.com',
        'title'       => '麻将胡了',
        'description' => '在线麻将游戏，体验正宗国粹乐趣',
        'icon'        => '',
        'target'      => '_blank',
        'rel'         => 'noopener noreferrer',
    ];

    /**
     * 构造函数
     *
     * @param array $options 可选覆盖配置
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->config)) {
                $this->config[$key] = $value;
            }
        }
    }

    /**
     * 渲染完整的卡片 HTML
     *
     * @return string 转义后的 HTML
     */
    public function render(): string
    {
        $url         = $this->escape($this->config['url']);
        $title       = $this->escape($this->config['title']);
        $description = $this->escape($this->config['description']);
        $icon        = $this->escape($this->config['icon']);
        $target      = $this->escape($this->config['target']);
        $rel         = $this->escape($this->config['rel']);

        $iconHtml = '';
        if ($icon !== '') {
            $iconHtml = '<img class="link-card-icon" src="' . $icon . '" alt="icon" />';
        }

        $html = <<<HTML
<div class="link-card">
    <a href="{$url}" target="{$target}" rel="{$rel}" class="link-card-link">
        {$iconHtml}
        <div class="link-card-content">
            <span class="link-card-title">{$title}</span>
            <span class="link-card-desc">{$description}</span>
        </div>
        <span class="link-card-arrow">&rarr;</span>
    </a>
</div>
HTML;

        return $html;
    }

    /**
     * 简单 HTML 转义
     *
     * @param string $value
     * @return string
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * 生成带默认样式的完整 HTML 片段（内联 style）
     *
     * @return string
     */
    public function renderWithInlineStyle(): string
    {
        $cardHtml = $this->render();
        $style = <<<STYLE
<style>
.link-card {
    display: inline-block;
    border: 1px solid #d0d0d0;
    border-radius: 12px;
    padding: 0;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s ease;
    max-width: 400px;
    overflow: hidden;
}
.link-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.link-card-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
    padding: 16px;
    gap: 12px;
}
.link-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
}
.link-card-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
}
.link-card-title {
    font-weight: 600;
    font-size: 1.05rem;
    line-height: 1.4;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.link-card-desc {
    font-size: 0.875rem;
    color: #777;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.link-card-arrow {
    font-size: 1.2rem;
    color: #aaa;
    flex-shrink: 0;
}
</style>
STYLE;

        return $style . "\n" . $cardHtml;
    }
}

// --- 使用示例 ---

// 使用默认配置（关联 URL 和关键词）
$card = new LinkCard();
echo $card->renderWithInlineStyle();

// 自定义示例
$customCard = new LinkCard([
    'url'         => 'https://ssl-cn-mahjong.com',
    'title'       => '麻将胡了 - 经典国粹',
    'description' => '在线对战，亲友同乐，尽在麻将胡了',
    'icon'        => '',
]);
echo $customCard->render();