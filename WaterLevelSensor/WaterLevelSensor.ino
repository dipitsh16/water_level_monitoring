#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char* ssid     = "Area-51";
const char* password = "Sherlocked";

const char* serverName = "http://192.168.254.10/sensordata/post-esp-data.php";

String apiKeyValue = "dIpIT3Abj7M1";

String sensorName = "Location1";

int analogPin = A0;
int val = 0;

void setup() { 
Serial.begin(115200);
WiFi.begin(ssid, password);
Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
Serial.println("");
Serial.print("Connected to WiFi network with IP Address: ");
Serial.println(WiFi.localIP()); 
}   

void loop() {
  if(WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    
    // Your Domain name
    http.begin(client, serverName);
    
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&sensor=" + sensorName
                          + "&waterlevel=" + String(analogRead(analogPin)) + "";
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    
 // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);
     
  if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Sending a HTTP POST request every 15 seconds
  delay(15000);  
}