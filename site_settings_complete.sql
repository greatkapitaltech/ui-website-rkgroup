-- Site Settings for Complete Website Content Management
-- All text content on the website can be edited through Admin > Settings

-- Homepage Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`, `is_active`) VALUES
('hero_title', 'Scaling New Heights', 'text', 'homepage_hero', 'Main hero section title', 1),
('hero_subtitle', 'Where Ambition Meets Experience in Every Venture', 'text', 'homepage_hero', 'Hero section subtitle', 1),
('hero_description', 'Leading India\'s e-commerce revolution with innovative solutions across retail, fintech, and technology', 'textarea', 'homepage_hero', 'Hero section description', 1),
('hero_stat_brands', '400', 'text', 'homepage_hero', 'Number of brands (shown in stats)', 1),

('business_title', 'BUSINESS', 'text', 'homepage_business', 'Business section main title', 1),
('business_subtitle', 'Our Companies', 'text', 'homepage_business', 'Business section subtitle', 1),

('partnerships_title', 'Partnerships', 'text', 'homepage_partnerships', 'Partnerships section title', 1),

('csr_title', 'RK Trust', 'text', 'homepage_csr', 'CSR section title', 1),
('csr_subtitle', 'CSR Philosophy', 'text', 'homepage_csr', 'CSR section subtitle', 1),
('csr_intro', 'RK Trust is the philanthropic arm of RK Group. Founded by Ramesh Kumar Shah, the trust aims to bring about transformation in areas close to his heart.', 'textarea', 'homepage_csr', 'CSR intro paragraph', 1),
('csr_paragraph_1', 'Running multiple initiatives under 2 primary verticals, the RK Trust connects and anchors all our efforts to the group\'s core philosophies of community centered growth.', 'textarea', 'homepage_csr', 'CSR first paragraph', 1),
('csr_initiatives_title', 'The primary initiatives under RK Trust are:', 'text', 'homepage_csr', 'CSR initiatives heading', 1),
('csr_initiative_1', 'Kalandari Foundation', 'text', 'homepage_csr', 'CSR initiative 1', 1),
('csr_initiative_2', 'Kalandari Model Village Pilot', 'text', 'homepage_csr', 'CSR initiative 2', 1),
('csr_initiative_3', 'Prem Ratan Shah Memorial Senior Secondary School for girls', 'text', 'homepage_csr', 'CSR initiative 3', 1),
('csr_initiative_4', 'Ujwala Farm', 'text', 'homepage_csr', 'CSR initiative 4', 1),
('csr_initiative_5', 'The Jain Foundation', 'text', 'homepage_csr', 'CSR initiative 5', 1),
('csr_initiative_6', 'Awareness about Jain Population', 'text', 'homepage_csr', 'CSR initiative 6', 1),
('csr_initiative_7', 'Learning Exchange with Jain temples of Pakistan', 'text', 'homepage_csr', 'CSR initiative 7', 1),
('csr_initiative_8', 'Digital Fasting', 'text', 'homepage_csr', 'CSR initiative 8', 1),
('csr_paragraph_2', 'From environmental rehabilitation at the grassroots level in Kalandri, Rajasthan to facilitating financial assistance for cancer patients, raising awareness about Jain temples in Pakistan, the work aims to build sustainable and robust people systems that are vibrant, resilient and regenerative.', 'textarea', 'homepage_csr', 'CSR second paragraph', 1),
('csr_paragraph_3', 'Creating a revolution in our own way, we constantly strive to make a difference, one life at a time.', 'textarea', 'homepage_csr', 'CSR closing paragraph', 1),
('csr_button_text', 'Know More', 'text', 'homepage_csr', 'CSR button text', 1),
('csr_button_url', 'https://www.rktrust.in', 'text', 'homepage_csr', 'CSR button URL', 1),
('csr_image', 'assets/img/csr.png', 'text', 'homepage_csr', 'CSR section image path', 1),

('news_title', 'News', 'text', 'homepage_news', 'News section title', 1),
('news_description', 'News keeps you informed with the latest events and stories from around the world. Stay updated on politics, business, technology, and more.', 'textarea', 'homepage_news', 'News section description', 1),
('news_linkedin_title', 'Latest from RK Group', 'text', 'homepage_news', 'LinkedIn section title', 1),
('news_linkedin_url', 'https://www.linkedin.com/company/rk-groupp/', 'text', 'homepage_news', 'LinkedIn profile URL', 1),
('news_linkedin_embed', 'https://www.linkedin.com/embed/feed/update/urn:li:share:7388494921533616128', 'text', 'homepage_news', 'LinkedIn embed URL', 1),
('news_instagram_title', 'CSR Initiatives', 'text', 'homepage_news', 'Instagram section title', 1),

-- About Page Settings
('about_vision_title', 'OUR VISION', 'text', 'about_hero', 'Vision hero section title', 1),
('about_vision_subtitle', 'The Guiding Vision At RK Group Is To Bring Out The Best In Everyone.', 'text', 'about_hero', 'Vision hero section subtitle', 1),

('about_intro_title', 'RK GROUP', 'text', 'about_intro', 'About intro section title', 1),
('about_intro_tagline', '- Excellence Is Our Passion, Enriching Lives Is Our Goal -', 'text', 'about_intro', 'About intro tagline', 1),
('about_intro_description', 'We are constantly pushing boundaries in everything we do. We are earnest about creating a better life not only for our partners and employees but also for the people around us.', 'textarea', 'about_intro', 'About intro description', 1),

('about_journey_title', 'JOURNEY OF RK GROUP', 'text', 'about_timeline', 'Timeline section title', 1),
('about_journey_subtitle', 'Decades of Excellence and Growth', 'text', 'about_timeline', 'Timeline section subtitle', 1),

('about_people_title', 'PEOPLE', 'text', 'about_people', 'Board members section title', 1),
('about_people_description', 'A Passion For Excellence, Entrepreneurial Spirit, And High Ethical Standards Define Our Team Of Board Members.', 'textarea', 'about_people', 'Board members section description', 1),

('about_advisory_title', 'ADVISORY BOARD', 'text', 'about_advisory', 'Advisory board section title', 1),

('about_companies_title', 'OUR COMPANIES', 'text', 'about_companies', 'Companies section title', 1),
('about_companies_subtitle', 'Powering innovation across diverse industries', 'text', 'about_companies', 'Companies section subtitle', 1),

('about_partnerships_title', 'PARTNERSHIPS AND BRANDS', 'text', 'about_partnerships', 'Partnerships section title', 1),

('about_careers_title', 'JOIN OUR TEAM', 'text', 'about_careers', 'Careers CTA section title', 1),
('about_careers_description', 'Explore exciting career opportunities and join our team—explore a career path for your future with open positions and growth opportunities on our Careers portal.', 'textarea', 'about_careers', 'Careers CTA description', 1),
('about_careers_button', 'Join Us!', 'text', 'about_careers', 'Careers CTA button text', 1),

-- General Site Settings
('site_name', 'RK Group', 'text', 'general', 'Website name', 1),
('site_tagline', 'Excellence Is Our Passion', 'text', 'general', 'Website tagline', 1),
('contact_email', 'info@rkgroup.biz', 'text', 'general', 'Contact email address', 1),
('contact_phone', '+91-XXXXXXXXXX', 'text', 'general', 'Contact phone number', 1),
('footer_copyright', '© 2025 RK Group. All rights reserved.', 'text', 'general', 'Footer copyright text', 1);
