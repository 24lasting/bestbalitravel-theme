<?php
if (!defined('ABSPATH')) exit;

class BBT_Widget_FAQ_Accordion extends \Elementor\Widget_Base {
    public function get_name() { return 'bbt-faq-accordion'; }
    public function get_title() { return esc_html__('FAQ Accordion', 'bestbalitravel'); }
    public function get_icon() { return 'eicon-accordion'; }
    public function get_categories() { return ['bbt-widgets']; }

    protected function register_controls() {
        $this->start_controls_section('section_faqs', ['label' => 'FAQs']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('question', ['label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Question']);
        $repeater->add_control('answer', ['label' => 'Answer', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Answer']);
        $this->add_control('faqs', ['type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [
            ['question' => 'What is included in the tour?', 'answer' => 'All tours include hotel pickup, English-speaking guide, lunch, entrance fees, and bottled water.'],
            ['question' => 'What should I bring?', 'answer' => 'We recommend comfortable walking shoes, sunscreen, camera, and light clothing.'],
            ['question' => 'Can I cancel my booking?', 'answer' => 'Yes! Free cancellation up to 24 hours before the tour starts.'],
        ]]);
        $this->end_controls_section();
    }

    protected function render() {
        $faqs = $this->get_settings_for_display()['faqs'];
        ?>
        <div class="bbt-faq-accordion">
            <?php foreach ($faqs as $i => $faq) : ?>
            <div class="bbt-faq-item <?php echo $i === 0 ? 'active' : ''; ?>">
                <button class="bbt-faq-question"><span><?php echo esc_html($faq['question']); ?></span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></button>
                <div class="bbt-faq-answer"><p><?php echo esc_html($faq['answer']); ?></p></div>
            </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-faq-accordion{max-width:800px}
            .bbt-faq-item{background:#fff;border-radius:16px;margin-bottom:12px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,.05)}
            .bbt-faq-question{width:100%;display:flex;justify-content:space-between;align-items:center;padding:20px 25px;background:none;border:none;font-size:16px;font-weight:600;text-align:left;cursor:pointer;transition:all .2s ease}
            .bbt-faq-question:hover{color:#F5A623}
            .bbt-faq-question svg{transition:transform .3s ease}
            .bbt-faq-item.active .bbt-faq-question svg{transform:rotate(180deg)}
            .bbt-faq-answer{max-height:0;overflow:hidden;transition:max-height .3s ease}
            .bbt-faq-item.active .bbt-faq-answer{max-height:200px}
            .bbt-faq-answer p{padding:0 25px 20px;margin:0;color:#666;line-height:1.7}
        </style>
        <script>
        document.querySelectorAll('.bbt-faq-question').forEach(function(btn){btn.addEventListener('click',function(){this.closest('.bbt-faq-item').classList.toggle('active')})});
        </script>
        <?php
    }
}
