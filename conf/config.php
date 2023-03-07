<?php

// 配置类
class Config {
	// 私有变量
	private $config_array;
	// 初始化私有变量(声明时不能使用表达式)
	public function __construct() {
		$this->config_array = array(
			'basic' => array(
				'excerpt_length' => 200, // 摘要的长度
				'display_ad' => false, // boolean 广告控制 true 显示广告, false 不显示
				'home_url' => get_bloginfo('url'),
				'site_name' => get_bloginfo('name'),
				'site_description' => get_bloginfo('description'),
				'time_zone' => timezone_open(get_option('timezone_string')), // timezone 时区
				'asset_uri' => get_stylesheet_directory_uri() . '/assets', // css, js 文件路径
				'logo' => '', // logo url 填入 logo url 将覆盖默认的图标
				'beian' => '此处填写备案号', // 备案号
				'enable_post_format' => array(
					'standard', 'aside', 'chat', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio'
				), // 要启用的格式
				'post_format_name' => array(
					'Standard' => '标准',
					'Aside' => '博客',
					'Image' => '图像',
					'Video' => '视频',
					'Quote' => '引用',
					'Link' => '链接',
					'Gallery' => '图集',
					'Status' => '状态',
					'Audio' => '音频',
					'Chat' => '聊天'
				), // 自定义格式名称
				'send_mail' => array(
					'to' => get_bloginfo('admin_email'), // 邮件接收人
				),
			),
			'query' => array(
				// feed 过滤参数
				'feed' => array(
					'after_date' => '7 days ago', // feed 输出内容的的起始时间
					'terms_not_in' => array(), // 排除的日志格式
				),
				// 首页查询过滤参数
				'home' => array(
					'terms_not_in' => array('post-format-aside', 'post-format-status', 'post-format-chat', 'post-format-quote', 'post-format-audio', 'post-format-video', 'post-format-link'),
				),
				// 足迹
				'Here' => array(
					'terms_in' => array('post-format-status'),
				),
				// 博客
				'Blog' => array(
					'terms_in' => array('post-format-aside', 'post-format-video'),
				),
			),
			// 定制配置参数
			'custom' => array(
				'date' => array(
				),
				'role' => array(
				),
				'auto_private_post_format' => array(), // 发布时自动加密的格式, 如希望 status 和 link 在发布时自动加密, 请填入: 'status', 'link'
			),
			// 错误配置参数
			'error' => array(
				// 错误代码 具体详情见错误详情
				'code' => array(
					'email_spam' => '1001',
					'email_hold' => '1002',
					'IP_spam'    => '1003',
					'IP_hold'    => '1004',
					'impostor'   => '1005',
					'channel_error_hash_empty' => '1006',
					'trackback_disabled'       => '1007',
					'empty_comment'            => '1008',
					'channel_error'            => '1009',
					'channel_hash_check_fail'  => '1010',
					'channel_error_fake_chnl'  => '1011',
				),
				// 错误详情
				'msg' => array(
					'1001' => 'email 存在垃圾评论。',
					'1002' => 'email 存在待审核评论。',
					'1003' => 'IP 存在垃圾评论。',
					'1004' => 'IP 存在待审核评论。',
					'1005' => '请不要冒用管理员邮箱。',
					'1006' => '未启用的评论来源。',
					'1007' => '不接受 Trackback。',
					'1008' => '请输入您的评论内容。',
					'1009' => '未启用的评论来源。',
					'1010' => '未启用的评论来源。',
					'1011' => '伪造评论来源。',
				),
			),
	
			// 评论控制参数 评论对象, 指依据评论者的 email 和 IP 确定的评论发起人, 下称评论对象或该对象
			'comment' => array(
				'check' => true, // boolean 是否启用评论控制
				'comment_check_key' => 'BRAVE', // string 用于校验评论来源是否合法的(可自定义, 生成md5 hash 使用)
				'form_action_dir' => home_url(''), // 评论处理文件所在的目录
				'comment_channel_field' => 'comment_channel', // 用于标记评论来源的字段, 这个字段对用户是透明的, 防止直接走 wp-comments-post.php
				'IP' => '1 day ago', // 根据 IP 控制异常评论的开始时间范围: 自当前时间按此值倒退(-1 day 等同于 1 day ago)
				'email' => array( // 根据 email 控制异常评论参照的开始时间
					'spam' => NULL, // 根据 email 控制垃圾评论参照的开始时间: NULL 不限日期, 参考全部评论
					'hold' => '30 days ago', // 根据 email 控制待审核评论参照的开始时间
					'approve' => '1 hour ago', // 根据 email 控制已审核评论参照的开始时间
				),
				'comment_text_field' => 'little_star', // 评论文本框字段名称
				'comment_status_convert_array' => array(
					'hold' => '0',
					'spam' => 'spam',
					'trash' => 'trash',
					'approve' => '1',
				),
				'threshold' => array( // 评论控制数量阈值, 实际值等于 n+1 , 超过阈值将触发错误处理逻辑
					'spam' => 0, // 垃圾评论零容忍, 该对象存在一条垃圾评论或放在回收站的评论即触发
					'hold' => 2, // 为 2 则最多容许该对象生成3条待审核评论, 超过则不允许继续提交评论
					'approve' => 9, // 已通过的评论, 为 9 则指定时间段内该对象存在 10 条评论后, 后续该对象的评论会被置为待审核
				),
			),
		);
	}
	
	/* 取分组数组内的元素 */
	public function get_config($group) {
		$group = $this->config_array[$group];
		return function($item = NULL) use(&$group) {
			return $group;
		};
	}
	
	/* 获取广告 */
	public function display_ad($ad_name) {
		$display_ad = $this->config_array['basic']['display_ad'];
		if (display_ad && is_callable($this->$ad_name())) {
			return $ad_name();
		}
	}
};

?>
