<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Pricing extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-pricing';
    }
    public function get_title()
    {
        return esc_html__('Activity Pricing Table', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-price-table';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_pricing', ['label' => 'Pricing']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', ['label' => 'Ticket Type', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Adult']);
        $repeater->add_control('age', ['label' => 'Age Range', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '12+ years']);
        $repeater->add_control('price', ['label' => 'Price', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rp 450,000']);
        $this->add_control('tickets', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Adult', 'age' => '12+ years', 'price' => 'Rp 450,000'],
                ['name' => 'Child', 'age' => '3-11 years', 'price' => 'Rp 300,000'],
                ['name' => 'Infant', 'age' => '0-2 years', 'price' => 'Free'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $tickets = $this->get_settings_for_display()['tickets'];
        ?>
        <div class="bbt-activity-pricing">
            <h3>💰 Pricing</h3>
            <table class="bbt-ap-table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Age</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $t): ?>
                        <tr>
                            <td><strong>
                                    <?php echo esc_html($t['name']); ?>
                                </strong></td>
                            <td>
                                <?php echo esc_html($t['age']); ?>
                            </td>
                            <td class="bbt-ap-price">
                                <?php echo esc_html($t['price']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <style>
            .bbt-activity-pricing {
                background: #fff;
                padding: 30px;
                border-radius: 20px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08)
            }

            .bbt-activity-pricing h3 {
                margin: 0 0 20px;
                font-size: 20px
            }

            .bbt-ap-table {
                width: 100%;
                border-collapse: collapse
            }

            .bbt-ap-table th,
            .bbt-ap-table td {
                padding: 15px;
                text-align: left;
                border-bottom: 1px solid #eee
            }

            .bbt-ap-table th {
                font-size: 13px;
                text-transform: uppercase;
                color: #666;
                font-weight: 600
            }

            .bbt-ap-price {
                font-weight: 700;
                color: #F5A623
            }
        </style>
        <?php
    }
}
