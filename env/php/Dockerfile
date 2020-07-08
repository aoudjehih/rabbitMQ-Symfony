FROM disc/php-amqp:latest

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# mhsendmail dependencies
RUN apt-get update -y && apt-get install -y --no-install-recommends \
    golang-go \
    git

# mhsendmail
RUN GOPATH=$HOME/go \
    PATH=$PATH:$GOROOT/bin:$GOPATH/bin \
    go get github.com/mailhog/mhsendmail && ln  ~/go/bin/mhsendmail /usr/bin/mhsendmail && echo "sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025" > /usr/local/etc/php/conf.d/sendmail.ini
