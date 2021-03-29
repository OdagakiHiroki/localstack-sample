FROM php:7.2-apache

# インストール後の Composer のフォルダ名とファイル名
ARG composer_dir=/usr/local/bin
ARG composer_filename=composer

RUN apt-get update \
  # Composer インストール
  && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  # && php -r "if (hash_file('sha384', 'composer-setup.php') !== '$composer_setup_hash') { echo '!!! Failed to install Composer !!!'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php --install-dir=$composer_dir --filename=$composer_filename \
  && php -r "unlink('composer-setup.php');" \
  # unzip コマンド (composer create-project で必要)
  && apt-get install -y unzip \