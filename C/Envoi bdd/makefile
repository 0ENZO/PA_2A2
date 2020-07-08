NAME = addFile

CC  = gcc
DEBUG = gdb


RM = rm -f
PTHREAD = -pthread
CFLAGS = -Wall -Wextra -c -g
##GTKLIB

LDFLAGS = $(PTHREAD) 

SRCS = try.c 
OBJS = $(SRCS:.c=.o)

all: $(NAME)

$(NAME):	$(OBJS) 
	$(CC) -o $(NAME) $(OBJS) $(LDFLAGS) $(LIBS)  -lmysqlclient

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
