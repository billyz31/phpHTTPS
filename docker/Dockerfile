FROM ubuntu:20.04
MAINTAINER xiaoyu(977856041@qq.com)

ENV DEBIAN_FRONTEND=noninteractive

#设置root账户密码，安装ssh服务
RUN echo "root:123456" | chpasswd
RUN apt-get update && apt-get install -y openssh-server wget curl libxml2 xz-utils iproute2 net-tools
ADD sshd_config /etc/ssh/sshd_config
RUN mkdir -p /var/run/sshd
RUN ssh-keygen -A

#给宿主机开放端口
EXPOSE 20
EXPOSE 21
EXPOSE 22
EXPOSE 80
EXPOSE 8010
EXPOSE 443
EXPOSE 9080
EXPOSE 30000
EXPOSE 30050
CMD ["/usr/sbin/sshd", "-D"]
