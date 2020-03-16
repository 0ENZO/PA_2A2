#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <gtk-3.0/gtk/gtk.h>
#include <gtk-3.0/gtk/gtkx.h>
#include <SDL2/SDL.h>
#include <SDL2/SDL_image.h>

void Accueil();
void AccueilDestroy();

GtkBuilder *builder;

//GtkWidget *sign;

void Accueil()
{
    GtkWidget *window;
    builder = gtk_builder_new_from_file("Accueil.glade");
    gtk_builder_connect_signals(builder, NULL);
    window  = GTK_WIDGET(gtk_builder_get_object(builder,"windows"));
    gtk_widget_show(window);
    //sign = GTK_WIDGET(gtk_builder_get_object(builder,"inscription"));
   // g_signal_connect (sign,"clicked",G_CALLBACK(inscription),window);

    gtk_main();
}

void AccueilDestroy(GtkWidget *widget,GtkWidget *window)
{
    gtk_widget_destroy(window);
    builder = gtk_builder_new_from_file("Accueil.glade");
    gtk_builder_connect_signals(builder, NULL);
    window  = GTK_WIDGET(gtk_builder_get_object(builder,"windows"));
    gtk_widget_show(window);
    //sign = GTK_WIDGET(gtk_builder_get_object(builder,"inscription"));
    //g_signal_connect (sign,"clicked",G_CALLBACK(inscription),window);
    gtk_main();
}

int main(int argc, char *argv[])
{
    gtk_init(&argc, &argv);
    Accueil();
    return 0;
}
