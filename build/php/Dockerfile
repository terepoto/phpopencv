FROM  php:8.2-fpm
EXPOSE 5173

RUN apt-get update && apt-get -y install git unzip zlib1g-dev libpq-dev libzip-dev libjpeg-dev libpng-dev zstd libopencv-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo_pgsql zip gd pdo_mysql mysqli

### Cmakeのインストール
RUN apt install build-essential checkinstall zlib1g-dev libssl-dev -y
RUN apt install wget
RUN wget https://github.com/Kitware/CMake/releases/download/v3.23.3/cmake-3.23.3.tar.gz
RUN tar -zxvf cmake-3.23.3.tar.gz
RUN cd cmake-3.23.3 && ./bootstrap && gmake && gmake install
RUN which cmake
RUN cmake --version

RUN cd /usr/local/src
RUN git clone https://github.com/opencv/opencv_contrib.git && git clone https://github.com/opencv/opencv.git
RUN cd opencv_contrib && git checkout tags/4.7.0 && cd ../opencv && git checkout tags/4.7.0 && cd ..
RUN mkdir build && cd build && cmake -D OPENCV_GENERATE_PKGCONFIG=ON -D OPENCV_GENERATE_PKGCONFIG=YES -D CMAKE_BUILD_TYPE=RELEASE -D CMAKE_INSTALL_PREFIX=/usr/local/opencv -D OPENCV_EXTRA_MODULES_PATH=../opencv_contrib/modules ../opencv
RUN cd build && make -j16 && make install && ldconfig
RUN pkg-config --cflags --libs opencv4
RUN pkg-config --modversion opencv4

RUN cd /usr/local/src
RUN git clone https://github.com/php-opencv/php-opencv.git
RUN cd php-opencv && phpize && ./configure --with-php-config=/usr/local/bin/php-config --enable-debug && make && make install

