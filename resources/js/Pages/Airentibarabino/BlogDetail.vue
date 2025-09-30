<script setup>
    import { useLanguage } from '@/Composables/useLanguage.js';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        blog: Object,
        relatedBlogs: Array
    });

    const { getTranslatedText } = useLanguage();
</script>

<template>
    <div>
        <section class="blog-detail-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="blog-detail">
                            <div class="blog-detail__image">
                                <img 
                                    :src="blog?.image || '/images/resources/default-blog.jpg'" 
                                    :alt="blog?.title || 'Blog Post'"
                                    class="img-fluid"
                                />
                            </div>
                            
                            <div class="blog-detail__content">
                                <div class="blog-detail__meta">
                                    <span class="blog-detail__date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ blog?.created_at ? new Date(blog.created_at).toLocaleDateString('en-US', { 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric' 
                                        }) : 'Recent' }}
                                    </span>
                                </div>
                                
                                <h1 class="blog-detail__title">{{ blog?.title || 'Blog Post' }}</h1>
                                
                                <div class="blog-detail__text" v-html="getTranslatedText(blog?.description_translations, blog?.description)" v-if="blog?.description">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-lg-5">
                        <div class="blog-sidebar">
                            <div class="blog-sidebar__widget">
                                <h3 class="blog-sidebar__title">Related Articles</h3>
                                <div class="blog-sidebar__posts" v-if="relatedBlogs && relatedBlogs.length > 0">
                                    <div 
                                        v-for="relatedBlog in relatedBlogs" 
                                        :key="relatedBlog.id"
                                        class="blog-sidebar__post"
                                    >
                                        <div class="blog-sidebar__post-image">
                                            <img 
                                                :src="relatedBlog.image || '/images/resources/default-blog.jpg'" 
                                                :alt="relatedBlog.title"
                                                class="img-fluid"
                                            />
                                        </div>
                                        <div class="blog-sidebar__post-content">
                                            <h4 class="blog-sidebar__post-title">
                                                <Link :href="`/news-insights/${relatedBlog.slug}`">
                                                    {{ relatedBlog.title }}
                                                </Link>
                                            </h4>
                                            <span class="blog-sidebar__post-date">
                                                {{ new Date(relatedBlog.created_at).toLocaleDateString('en-US', { 
                                                    month: 'short', 
                                                    day: 'numeric' 
                                                }) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="blog-sidebar__no-posts">
                                    <p>No related articles found.</p>
                                </div>
                            </div>
                            
                            <div class="blog-sidebar__widget">
                                <h3 class="blog-sidebar__title">Categories</h3>
                                <ul class="blog-sidebar__categories">
                                    <li><Link to="/news-insights">All Articles</Link></li>
                                    <li><Link to="/services">Our Services</Link></li>
                                    <li><Link to="/about">About Us</Link></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.blog-detail-page {
    padding: 120px 0 90px;
    background: #f8f9fa;
}

/* Ensure proper header styling */
.page-wrapper {
    background: #fff;
}

.blog-detail {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.blog-detail__image {
    position: relative;
    overflow: hidden;
}

.blog-detail__image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.blog-detail__content {
    padding: 40px;
}

.blog-detail__meta {
    margin-bottom: 20px;
}

.blog-detail__date {
    color: #666;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.blog-detail__date i {
    color: #dc3545;
}

.blog-detail__title {
    font-size: 32px;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 25px;
    line-height: 1.3;
}

.blog-detail__text {
    color: #666;
    line-height: 1.8;
    font-size: 16px;
}

.blog-detail__text h1,
.blog-detail__text h2,
.blog-detail__text h3,
.blog-detail__text h4,
.blog-detail__text h5,
.blog-detail__text h6 {
    color: #2c2c2c;
    margin: 25px 0 15px;
    font-weight: 600;
}

.blog-detail__text p {
    margin-bottom: 20px;
}

.blog-detail__text ul,
.blog-detail__text ol {
    margin: 20px 0;
    padding-left: 30px;
}

.blog-detail__text li {
    margin-bottom: 8px;
}

.blog-sidebar {
    padding-left: 30px;
}

.blog-sidebar__widget {
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.blog-sidebar__title {
    font-size: 24px;
    font-weight: 600;
    color: #2c2c2c;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #dc3545;
}

.blog-sidebar__post {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.blog-sidebar__post:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.blog-sidebar__post-image {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 5px;
    overflow: hidden;
}

.blog-sidebar__post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.blog-sidebar__post-content {
    flex: 1;
}

.blog-sidebar__post-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    line-height: 1.4;
}

.blog-sidebar__post-title a {
    color: #2c2c2c;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-sidebar__post-title a:hover {
    color: #dc3545;
}

.blog-sidebar__post-date {
    color: #666;
    font-size: 14px;
}

.blog-sidebar__categories {
    list-style: none;
    padding: 0;
    margin: 0;
}

.blog-sidebar__categories li {
    margin-bottom: 10px;
}

.blog-sidebar__categories a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
    display: block;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.blog-sidebar__categories a:hover {
    color: #dc3545;
}

.blog-sidebar__no-posts {
    text-align: center;
    color: #666;
    padding: 20px 0;
}

@media (max-width: 991px) {
    .blog-sidebar {
        padding-left: 0;
        margin-top: 40px;
    }
    
    .blog-detail__title {
        font-size: 28px;
    }
    
    .blog-detail__content {
        padding: 30px;
    }
}

@media (max-width: 767px) {
    .blog-detail-page {
        padding: 80px 0 60px;
    }
    
    .blog-detail__title {
        font-size: 24px;
    }
    
    .blog-detail__content {
        padding: 20px;
    }
    
    .blog-sidebar__widget {
        padding: 20px;
    }
}
</style>
