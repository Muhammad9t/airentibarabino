<script setup>
    import { useLanguage } from '@/Composables/useLanguage.js';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        blogs: Array
    });

    const { getTranslatedText } = useLanguage();
</script>

<template>
    <div>
        <section class="news-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section-title text-center">
                            <span class="section-title__tagline" data-i18n-key="latest_news_articles">
                                Latest News & Articles
                            </span>
                            <h2 class="section-title__title" data-i18n-key="news_insights_title">
                                News & Insights
                            </h2>
                        </div>
                    </div>
                </div>
                
                <div class="row" v-if="blogs && blogs.length > 0">
                    <div 
                        v-for="blog in blogs" 
                        :key="blog.id"
                        class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp"
                        data-wow-delay="100ms"
                        data-wow-duration="1500ms"
                    >
                        <div class="news-card">
                            <div class="news-card__image">
                                <img 
                                    :src="blog.image || '/images/resources/default-blog.jpg'" 
                                    :alt="getTranslatedText(blog.description_translations, blog.description)"
                                    class="img-fluid"
                                />
                                <div class="news-card__date">
                                    <span>{{ new Date(blog.created_at).getDate() }}</span>
                                    <p>{{ new Date(blog.created_at).toLocaleDateString('en-US', { month: 'short' }) }}</p>
                                </div>
                            </div>
                            <div class="news-card__content">
                                <h3 class="news-card__title">
                                    <Link :href="`/news-insights/${blog.slug}`">
                                        {{ blog.title }}
                                    </Link>
                                </h3>
                                <p class="news-card__text">
                                    {{ getTranslatedText(blog.description_translations, blog.description_preview || blog.description).substring(0, 150) }}...
                                </p>
                                <Link 
                                    :href="`/news-insights/${blog.slug}`" 
                                    class="news-card__btn"
                                >
                                    Read More
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-else class="row">
                    <div class="col-xl-12">
                        <div class="text-center py-5">
                            <h3>No articles found</h3>
                            <p>Check back later for the latest news and insights.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.news-page {
    padding: 120px 0 90px;
    background: #f8f9fa;
}

/* Ensure proper header styling */
.page-wrapper {
    background: #fff;
}

.news-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 30px;
    height: 100%;
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.news-card__image {
    position: relative;
    overflow: hidden;
}

.news-card__image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.news-card:hover .news-card__image img {
    transform: scale(1.05);
}

.news-card__date {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #dc3545;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    text-align: center;
    font-weight: 600;
}

.news-card__date span {
    display: block;
    font-size: 24px;
    line-height: 1;
}

.news-card__date p {
    margin: 0;
    font-size: 14px;
    text-transform: uppercase;
}

.news-card__content {
    padding: 30px;
}

.news-card__title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    line-height: 1.4;
}

.news-card__title a {
    color: #2c2c2c;
    text-decoration: none;
    transition: color 0.3s ease;
}

.news-card__title a:hover {
    color: #dc3545;
}

.news-card__text {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.6;
}

.news-card__btn {
    display: inline-block;
    background: #dc3545;
    color: #fff;
    padding: 12px 25px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.news-card__btn:hover {
    background: #c82333;
    color: #fff;
    transform: translateY(-2px);
}
</style>
