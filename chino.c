#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

const int pinRST = 15;
const int pinSDA = 5;
const int buzzer = 27;
const int led = 2;

MFRC522 rfid(pinSDA, pinRST);
String urlCaracteres;

const char *ssid = "MEGACABLE-B1D8";
const char *password = "B7P9NXLFS6GB";

String serverName = "https://api.thingspeak.com/update?api_key=46VXEH5KU40D9GCZ";

void setup()
{
    pinMode(buzzer, OUTPUT);
    pinMode(led, OUTPUT);
    SPI.begin();
    rfid.PCD_Init();
    Serial.begin(9600);
    WiFi.begin(ssid, password);
    Serial.println("Conectando...");

    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.print("Conectado a la red wifi, IP: ");
    // Serial.println(WiFi.localIP);
    //////bip(100);
    delay(400);
    ////bip(100);
}

void loop()
{
    if (rfid.PICC_IsNewCardPresent())
    {
        if (rfid.PICC_ReadCardSerial())
        {
            Serial.print("UID de la tarjeta: ");
            for (byte i = 0; i < rfid.uid.size; i++)
            {
                urlCaracteres += rfid.uid.uidByte[i];
            }
            Serial.print(urlCaracteres);
            Serial.println();

            if (urlCaracteres == "131138197145" || urlCaracteres == "1792533149")
            {
                if (urlCaracteres == "131138197145")
                {
                    bip(30);
                    urlCaracteres = "50";
                    Serial.println("ID 50");
                }
                if (urlCaracteres == "1792533149")
                {
                    bip(30);
                    urlCaracteres = "100";
                    Serial.println("ID 100");
                }
                Serial.println("Tarjeta correcta ");
                digitalWrite(led, HIGH);

                if (WiFi.status() == WL_CONNECTED)
                {
                    HTTPClient http;
                    String url = serverName + "&field1=" + urlCaracteres;
                    http.begin(url.c_str());
                    int codigoRespuesta = http.GET();

                    if (codigoRespuesta > 0)
                    {
                        Serial.print("Codigo de respuesta HTTP: ");
                        Serial.println(codigoRespuesta);
                        digitalWrite(led, LOW);
                    }
                    else
                    {
                        Serial.print("Codigo error: ");
                        Serial.println(codigoRespuesta);
                        http.begin(url.c_str());
                        int codigoRespuesta = http.GET();

                        if (codigoRespuesta > 0)
                        {
                            Serial.print("Codigo de respuesta HTTP: ");
                            Serial.println(codigoRespuesta);
                        }
                    }
                    http.end();
                }
                else
                {
                    Serial.println("Wifi desconectado... ");
                }
            }
            else
            {
                bip(70);
                Serial.println("No registrado");
                delay(1000);
            }
        }
    }
    urlCaracteres = "";
}

void bip(int demora)
{
    digitalWrite(buzzer, HIGH);
    delay(demora);
    digitalWrite(buzzer, LOW);
}
