### flight status data of Velana International Airport, Maldives URL 'http://fis.com.mv/'
from bs4 import BeautifulSoup
import requests


## ARRIVALS ##
# get data
Arrive_URL = 'http://www.fis.com.mv/xml/arrive.xml'

Arrive_data = requests.get(Arrive_URL)

#load data
soup = BeautifulSoup(Arrive_data.content , 'xml')

for flights in soup.find_all('Flight'): 
    flight = flights
    if flight.Status.text == 'LA': 
      astatus = 'LANDED' 
    elif flight.Status.text == 'CA': 
      astatus = 'CANCELLED'
    elif flight.Status.text == 'DE': 
      astatus = 'DELAYED'
    else:  
      astatus = ''

    if flight.CarrierType.text == 'D':
      aFlight_type = 'DOMESTIC'
    else:
      aFlight_type = 'INTERNATIONAL'
    print("ARRIVALS")
    print("Flight Name:", flight.AirLineName.text)
    print("Flight No:",flight.FlightID.text)
    print("From:", flight.Route1.text)
    print("To:",flight.Route2.text)
    print("Scheduled:",flight.Scheduled.text)
    print("Estimated:", flight.Estimated.text)
    print("Date:", flight.Date.text)

    print("Status:", astatus)
    print("Type:", aFlight_type)

    print()
    
## DEPARTURES 
# get data
Depart_URL = 'http://www.fis.com.mv/xml/depart.xml'

Depart_data = requests.get(Depart_URL)

#load data
soup = BeautifulSoup(Depart_data.content , 'xml')

for flights in soup.find_all('Flight'):
    flight = flights
    print("DEPARTURES")
    if flight.Status.text == 'FZ': 
      dstatus = 'CLOSED'
    elif flight.Status.text == 'CA': 
      dstatus = 'CANCELLED'
    elif flight.Status.text == 'DE': 
      dstatus = 'DELAYED'
    elif flight.Status.text == 'BO': 
      dstatus = 'BOARDING'
    elif flight.Status.text == 'FC': 
      dstatus = 'FINAL CALL'
    elif flight.Status.text == 'DP': 
      dstatus = 'DEPARTED'
    else:  
      dstatus = ''

    if flight.CarrierType.text == 'D':
      dFlight_type = 'DOMESTIC'
    else:
      dFlight_type = 'INTERNATIONAL'
    print("ARRIVALS")
    print("Flight Name:", flight.AirLineName.text)
    print("Flight No:",flight.FlightID.text)
    print("From:", flight.Route1.text)
    print("To:",flight.Route2.text)
    print("Scheduled:",flight.Scheduled.text)
    print("Estimated:", flight.Estimated.text)
    print("Date:", flight.Date.text)
    print("Status:", dstatus)
    print("Type:", dFlight_type)

    print()



