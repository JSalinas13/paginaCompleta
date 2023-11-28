#include <18F4550.h>
#DEVICE ADC = 10
#USE DELAY(clock = 20000000, crystal)        // Para PIC18F4550 cambiar por: #include <18F4550
#build(reset = 0x02000, interrupt = 0x02008) // Asigna los vectores de reset e interrupción para la versión con bootloader
#org 0x0000, 0x1FFF {}                       // Reserva espacio en memoria para el bootloader
#FUSES HS, NOPROTECT, NOWDT, NOBROWNOUT, PUT, NOLVP
//-------------------------------------------------------------------------------
#USE RS232(stream = SERIE, BAUD = 9600, PARITY = N, XMIT = PIN_C6, RCV = PIN_C7, BITS = 8)
// #use i2c(Master, Fast = 100000, sda = PIN_B0, scl = PIN_B1, force_sw)
// #include <i2c_Flex_LCD.c>

#use fast_io(b)
#use fast_io(d)
#define TRIGGER_PIN PIN_B7
#define ECHO_PIN PIN_D1
float dis = 0.0;
unsigned int16 duration;
float distance;

float medirDistancia()
{
    // Generate a trigger pulse
    output_high(TRIGGER_PIN);
    delay_us(10);
    output_low(TRIGGER_PIN);

    // Wait for the echo pulse to start
    while (!input(ECHO_PIN))
        ;

    // Start the timer
    set_timer1(0);

    // Wait for the echo pulse to end
    while (input(ECHO_PIN))
        ;

    // Read the timer value
    duration = get_timer1();

    // Calculate the distance in centimeters
    distance = (float)duration * 0.017; // Speed of sound in air is approximately 343 meters/second

    // printf("Distance: %.2f cm\r\n", distance);
    // if(distance <=5.0){
    //  output_low (pin_b3) ;
    // }else{
    //  output_high(pin_b3) ;
    // }

    return distance;
}

void avance()
{
    output_high(pin_b2);
    output_high(pin_b4);
    output_low(pin_b1);
    output_low(pin_b3);
}

void reversa()
{
    output_low(pin_b2);
    output_low(pin_b4);
    output_high(pin_b1);
    output_high(pin_b3);
}

void derecha()
{
    output_high(pin_b2);
    output_low(pin_b4);
    output_low(pin_b1);
    output_high(pin_b3);
}

void izquierda()
{
    output_low(pin_b2);
    output_high(pin_b4);
    output_high(pin_b1);
    output_low(pin_b3);
}

void para()
{
    output_low(pin_b2);
    output_low(pin_b4);
    output_low(pin_b1);
    output_low(pin_b3);
}

void main(VOID)
{

    setup_timer_1(T1_INTERNAL | T1_DIV_BY_8);

    // lcd_init(0x4E, 16, 2); // Inicializa la pantalla LCD
    // lcd_backlight_led(ON); // Enciende la luz de fondo
    // set_tris_b(0x00);      // 00000000 00000000
    // set_tris_d(0xFF);

    while (true)
    {
        dis = medirDistancia();
        // lcd_clear(); // Limpia el LCD
        // Pregunta si hay algun dato recibido
        // printf(lcd_putc, "El número es: %f", dis);

        // Borra el mensaje
        // lcd_clear();
        IF(dis <= 5.0)
        {
            output_low(pin_b6);
        }
        ELSE
        {
            output_high(pin_b6);
        }

        IF(kbhit())
        {
            CHAR Caracter = getc(); // Guarda el caracter

            IF(Caracter == '0')
            {
                // Izquierda
                para();
                // Caracter = getc ();
            }

            IF(Caracter == '1')
            {
                // Avance
                avance();
                // Caracter = getc ();
            }

            IF(Caracter == '2')
            {
                // Reversa
                reversa();
                // Caracter = getc ();
            }

            IF(Caracter == '3')
            {
                // Derecha
                derecha();
                // Caracter = getc ();
            }

            IF(Caracter == '4')
            {
                // Izquierda
                izquierda();
                // Caracter = getc ();
            }
        }
    }
}