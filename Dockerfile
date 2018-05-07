FROM tapklik/composer-base:v1.0.0

WORKDIR /etc/apache2/sites-available
RUN sed -i 's/{{SERVICE}}/onead.tapklik.com/g' 000-default.conf
RUN a2dissite 000-default.conf
RUN a2ensite 000-default.conf

COPY . /var/www/html/onead.tapklik.com/

WORKDIR /var/www/html/onead.tapklik.com
RUN composer install \
	&& cp .env.example .env \
	&& php artisan key:generate \
	&& npm install \
	&& chown -R www-data bootstrap/cache \
	&& chown -R www-data storage \
	&& chmod a+x entrypoint.sh \
	&& ls -ll

ENTRYPOINT ["/var/www/html/onead.tapklik.com/entrypoint.sh"]
