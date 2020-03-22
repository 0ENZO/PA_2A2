NAME = qrcode

CC  = gcc
DEBUG = gdb


RM = rm -f
PTHREAD = -pthread
CFLAGS = -Wall -Wextra -c -g
##GTKLIB
GTKLIB = `pkg-config --cflags --libs gtk+-3.0`
LDSLIB = `sdl2-config --libs`
LDFLAGS = $(PTHREAD) $(GTKLIB) -export-dynamic $(LDSLIB)

SRCS = main.c qrcodegen.c

OBJS = $(SRCS:.c=.o)

all: $(NAME)

$(NAME):	$(OBJS) 
	$(CC) -o $(NAME) $(OBJS) $(LDFLAGS) $(LIBS)  -lmysqlclient -lSDL2_image

$(OBJS): $(SRCS)
	$(CC) $(CFLAGS) $(GTKLIB) $(SRCS)

clean:
		$(RM) $(OBJS)

fclean: clean
		$(RM) $(NAME)

re: fclean all

.PHONY: debug valgrind

valgrind: $(NAME)
	valgrind ./$(NAME)

debug: $(NAME)
	$(DEBUG) $(NAME)
