Attribute VB_Name = "ReelModule"
'Pricing found in procedures:
' lookupPRICE (in prccheck form), calcREELprice, writeQUOTEtoDB
' also in all accessory subroutines, getHOSEfittings
'also in hoseinput form insertDUALpricing routine
'search for 2013

'REVISION HISTORY
'2002-1.0 - updated all pricing to 2002 and sent to reps 3/1/02
'2002-1.1
'  - fixes error where additional discount for CM reel wasn't showing on quote
'    and neither discount was showing for TMR reel.
'  - Fixes error where hose ID code for a stored hose was calculating incorrectly (always 4)
'  - changes so pendant reel shows roller guides and limit switches as included
'  - allows S16 to be explosion proof
'  - fixes error where weight of SM24 reels were incorrect
'  - allows reverse rotation of SHO & TMR reels
'  - CM reel shows dog & ratchet and roller guide as included
'  - allows INSIDE SALES to override UH/UE reel width
'  - fixed error where if you went to model selection screen, picked models and then went
'    back and changed either cable/hose or applicaiton, invalid reels would be searched
'  - removed reference to EZ springs for CM - instead we use U, V
'  - changed code so user MUST specify hand pull application to have hand pull springs quoted
'  - updates ReelData.mdb to include hand pull springs for HM
'  - fixes errors that occured in pricing, weight and dims if you ran quote, closed it and ran it immediately again
'    program was applying hazard duty and rev rotate adders on top of each other
'  - fixes error that closed quote if you selected "No" upon finishing TWO times in a row
'  - fixes errors in U-reel selection which were resuling from invalid drum calculations
'  - fixes error that occurred if user tried to specify U-reel frame
'  -allows insides sales to select specific model whether valid or not
'Version 2002 - 1.2
'  - fixes error that occured on 1/0, 2/0 cables causing type mismatch in writeDETAILS sub
'Version 2002 -1.3
'  - fixes error tht occurs if you double click drum diameter range on S reel or Kreel input
'  - fixes error that could occur when backing up or compacting databases
'    which resulted from open databases - added clearDB to tools and repairALLdb
'Version 2002-1.4 sent inside 6//13
'  - fixes some type mismatch issues with cable(1).XXX variables
'  - fixes error with hose clamp/ferrule, pipe fitting qty discrepencies for UH or HM
'  - CRUCIAL fixes error where it would select a reel with a drum min diameter less than calculated min
'version 2002-1.5
'  - crucial for INSIDe - fixes error where if manually change U-Reel spool width (only inside can) it didn't reflect in calcs
' adds clearDB call to exitITEM sub which fixes error that occasionally occured backing up DB's
'version 2002-1.6
'   -adds note showing limit switch standard on P reel.  Also changed to allow cable grips to be quoted as an accessory
'    for P reel.
'   - shows dog & ratchet as standard on HM reel (previously N/A)
'version 2003-1.0
'   - updates to 2003 pricing
'version 2003-2.0
'   -  Fixes error on price check where for CM reels, differemce in spring wasn't affecting price
'version 2003-3.0 11/03
'    - Fixes error which allowed user to quote reel without collector price
'Version 2004-1.0 updates to 2004 pricing
'Version 2004-1.1 12/31/04 fixes error where CM reel pricing wasn't showing(based on collector pricing)
'Version 2004-1.2  2/20/04 fixes error with cable grp price "027618"  SHOWED 1138 instead of 118
'Version 2004-1.3  3/13/04 fixes error where dual hose steel was too long of a description and runtime error occurred
'                          also updates Marztec contact info.
'                          removed some warning notes for inside sales
'                          if special cable quoted, it is automatically installed
'                          installed  cable pricing is rounded so cost/ft comes out to nearest cent
'                           fixed some errors with including/not including cable on quote modifications
' Version 2004-1.4  5/15/04 Fixes calc error which occurred if user manually input a SAG %.  It would default to standard and not use
'                           the entered amount.
'                           Fixes error when inside sales changed PN on type "OTHER" cable it wouldn't price it correctly.
'                           Updates Support screen to show my new e-mail
' Version 2004-1.5  6/18/04 Fixes error which allowed reps to quote UE reels
'                           Fixes error where 412 collector on MMD wasn't calculating hook-up cable correctly
'                           Adds 4 letters of rep name to quote #
' Version 2004-1.6          If inside sales, use 4 letters of e-mail instead of repname for quote ID
'                           If inside sales, do not put SP at end of PN
' Version 2004-1.7          Fixes error where "no current record" was occuring if user specified a reel with "None" as the gear ratio.  Instead of looking
'                           for reels with NULL in the gear field, it was looking for reels with '' and this caused the problem.  Also an issue w/price lookup.
' Version 2004-1.8          Fixes minor errors on input screens (discovered upgrading to .NET)
'                           Fixes pricing in database (I sent out wrong ones in v2004-1.7)
 '                          Fixes error which wouldn't allow input of characters for QuoteID lookup.
' Version 2004-1.9 8/25/04  Fixes error when you manually entered a cable like SO 10AWG, 30 Cond it caused invalid pricing because as you type "3" as part of 30AWG, it would
'                           store the price/ft installed cost of a 10AWG, *3* conductor cable and not clear it after you tyed the '0'
'                           Steve schmitz was getting run-time error 94 "Invalid Use of Null" because he didn't have an e-mail address entered so quoteId couldn't be generated.  fixed
'                           Fixes error in reel DB where empty collector field for frames up to 28" had single space and for 32" frame they were null.
'Version 2004-1.10          Fixes error in shaft stress calculation if user quotes SHO Monospiral.  It was looking at the spool method for TMR (which defaults to Random Wrap)
'Version 2005-1.0           Updates all pricing to 2005. Fixes error entering dual hose - filling in fields wrong
'                           unDID fix from 204-1.7
'Version 2005-1.1           Fixes error where reels with special collectors (ie 412-13) could be quoted even though pricing NA.  simply added <=0 check instead of =0
'Version 2005-1.2           Fixes error which required reps to enter e-mail address for themselves or they would get invalid use of Null message #94
'                           Fixes error where extra weight wasn't added for geared S and MMD reels
'Version 2005-1.3           Eliminated zipping during backup because of errors occuring on XP machines
'Version 2005-1.4    -Fixed error with SM32 reels - if 1005 or 1006 we should allow TVWY gears, if 1007 or 1008 we should allows VWY.  Was only allowing "All" selection
'                    - Fixed error where if you entered cable and then went back in to edit it you couldn't change voltage because no choices were shown.  Added code to activiate event
'                    - fixes error where if you exceeded maximum length of a field it wouldn't let you hit backspace to fix
'                    - adds note to quote modifications section letting user know if they change customer data it will change for all quotes previously done
'                    - fixes error where Hand Pull applications were not picking proper CM reel (already fixed in vb.net)
'                    - fixes error on price check screen in which the discounts were being added (20%+10%) rather than taking 20% off, then 10% off of that.
'2006-1.0            Updates to 2006 pricing.  Also fixes error where HM hand pull wouldn't find any models because we didn't have U,V springs in the HM database
'                    Also fixes error where CM/HM/K pricing would not be shown because collector price was -1
'2006-2.0         Allows user to create MS-Word quotes
'2006-2.1       Fixes error which allowed quote for special collector (i.e. 620) even though no pricing was available
'               Set it up so inside sales is prompted to enter price less than 20000 and reps can't quote reel
'2006-2.2       Changes QuoteID generation so that Hour/Minute/Sec portion is replaced by random numbers from 0-99 because of issues with Tami's computer.
'                Fixes issues caused by backup where databases were being erased.
'2007-1.0        Updates to 2007 pricing
'2007-2.0        Fixes error where CM and K reels were not showing pricing because collector price wasn't found (it shouldn't be because it's built into price!)
'                Took out TMR quote capability for reps only (per SS)
'2007-3.0       Adds RANDOMIZE statement to CreatQuoteID because there was a pattern to the ID's being generated.
'               Changes my e-mail address to wi.rr.com
'               if CM came up with 5,7,9 or 11 poles, we round that to next highest per SS
'2007A-1.0      Changes PN's to SAP format (precede with a "GR")
'               Changes TMR delivery to 10-12 weeks per SS
'               Updates all pricing to 2007A.  Fixes error where MMD rollerguide was not called out on 18 frame with hoop guides
'               added "Set myTABLE = Nothing" throughout
'2007A-1.1 (Ver 2007-5) Fixes error where CM reel could not be quoted with Ball Stop
'2007A-1.2 (ver 2007-6) Fixes error where wrong Ball stop PN called out.  Modifies cable length calculation to round up to nearest whole foot.  Pricing calc of cable
'                       changed to exactly match price book and not worry about cost/foot being a even amount.
 '                       Updates my e-mail on HELP screen
'2007A-1.3 (ver 2007-7)  Changes cable stacking calcs for SHO/TMR reels so that instead of stacking 4x4 (example), it calculates stacking as 4,3,4,3  per SS
'                         Fixes error where a collector such as 420 without a price (-1 in database) was allowing user to quote reel anyway.
'2007A-1.4 (ver 2007-8) Added website listing to background caption
'2007A-2.0 (ver 2007-9) Removed all SSFrames and SSPanels to attempt to make Vista compatible
'2008-1.0  Updates all pricing to 2008. Changes Hose PSI from 315 to 300
'  Fixes error caused by 2007A-1.2 change to cable stacking for SHO/TMR.  SHould have only applied to Random Wrap, it was also appying to Monospiral.
'2008-1.1  Fixes error with ferrules, clamps and pipe fitting quantities not being correct if hose quoted.  Now matches price book and VC per SS.
'Version 2008A 1.0  (2008-2.0) Updates all pricing to 2008A
'Version 2008A 2.0  (2008-3.0) Fixes glitch with cable pricing if user specifies own price.  Looks in database
'                              for similar cable, grabs installation fixed price and uses along with user entered per foot price.
'                              Previously, if user entered per foot price manually, but quoted installed, it quoted the price book price, not the user input
'Version 2010-1.0   updates all pricing to 2010
'                   removed dual vinyl 0.75" id per ss request
'                   Changes cable stacking calcs for U reels so that instead of stacking 4x4 (example), it calculates stacking as 4,3,4,3  per SS
'                   Added Hoop Guides as an option for UH reels
'Version 2010-1.1   Adds note to calculation report that shows the alternate hose stacking arrangement
'Version 2011-1.0   updates all pricing to 2011
'Version 2011-1.0  added 0.75 inch dual back in without data, user must enter.  Added reminder note to consider dual contents per SS
'Version 2012-1.0   updates all pricing to 2012
'Version 2012 1.1  (2012-1.1) Adds ability for user to change backup location (inside: server)
'Version 2012-6.0 Updates to VB6
'Version 2013-1.0   updates all pricing to 2013
'Version 2013-1.1 Fixes error 6148 that popped up if user was selecting from customer with over 8 contacts.  Also, defaulted model1 and model2 tabs to S and K as previous
'Version 2013-2.0 Fixes error where if you were in "Quick Step" it would always take you to electric reels, even if you entered hose per B. Cundy   7/2013
'                 Fixes error where you would get an error if you put in AWG >4 and <12 and HAND PULL, it would look for CM reels per T. Wendy 7/2013
'Version 2013-3.0  Fixes error Bruce got in Findthereel that was error 55, file aleady open.
'                   also removes a few random msgs that popped up "loooooop""ccccccc""cddddddddd"
Option Explicit
'Declare Function GetModuleUsage% Lib "Kernel" (ByVal hModule%)
'Declare Function GetModuleHandle% Lib "Kernel" (ByVal filename$)
'Declare Sub FreeLibrary Lib "Kernel" (ByVal hLibModule As Integer)
'Declare Function diskspacefree Lib "Setupkit.dll" () As Long


Public Type reelDATA
  MODELnum As String
  SERIES As String
  FRAME As String
  SPRING As String
  MOTOR As String
  COLL As String
  COLLECTORCOST As Single
  PRETENSION As String
  drum As String
  COST As Single
  SPOOLWIDTH As String
  SPOOLDIAM As String
  totalREELprice As Single
  turnsLIMIT As Single
  compartmentCAPACITY As String
  turnsCAPACITY As String
  torqWfullREEL As String
  torqueCAPACITY As String
  maxCAPACITY As String
  notRECMNDflag As Boolean
  locationPOINTER As Integer  'used to sort all valid models by cost, series
  PriceRank As Integer
  invalidWARN As Boolean
  modelNOTE As String
  modelWGT As Single
  extraCABLE As Single
  dimWIDTH As Single
  dimHEIGHT As Single
  dimDEPTH As Single
  quoteFLAG As Integer
  optionsSELECTED As Boolean
  selectionORDER As Integer
End Type

Public validREEL() As reelDATA  'stores reels which have been selected by program

Public Type optDATA
  rollerGUIDEresp As Boolean
  rollerGUIDEappl As String
  rollerGUIDEmatl As String
  hoopGUIDEresp As Boolean
  limitSWITCHresp As Boolean
  pivotBASEresp As Boolean
  dogRATCHETresp As Boolean
  spoolLOCKresp As Boolean
  ballSTOPresp As Boolean
  ballSTOPsize As String
  cableGRIPresp As Boolean
  revROTATEresp As Boolean
  hazardDUTYresp As Boolean
End Type
Public optANDacc() As optDATA
Public newOPT() As optDATA
Public reelDETLfileNAME As String
Public modelINDEX As Integer

Public SWopt As Boolean
Public Type invalidRESULT
  invalidMODEL As String 'store model number which wasn't valid
  invalidREASON(4) As Boolean  'store reasons invalid
End Type

Public invalidREEL() As invalidRESULT
Public invalidWARNING As Boolean
Public invalidCOUNT As Single  'stores number of invalid reels
Public applCHANGED As Boolean
Public hoseWGTboth As Single
Public KdimensA As Single
Public UreelWIDTHinp As String
Public UreelWIDTH As Single
Public hoseIDcode As String
Public maxSPRINGturns(1 To 6) As Single
Public maxTURNSforFIRSTpartOFcurve(1 To 6) As Single
Public slopeFIRSTpartOFcurve(1 To 6) As Single
Public yinterceptFIRSTpartOFcurve(1 To 6) As Single
Public maxTURNSforSECONDpartOFcurve(1 To 6) As Single
Public slopeSECONDpartOFcurve(1 To 6) As Single
Public yinterceptSECONDpartOFcurve(1 To 6) As Single
Public maxTURNSforTHIRDpartOFcurve(1 To 6) As Single
Public slopeTHIRDpartOFcurve(1 To 6) As Single
Public yinterceptTHIRDpartOFcurve(1 To 6) As Single
Public unusedSPRINGturnsFORlift As Single
Public availableSPRINGturnsFORlift As Single
Public shaftSTRESS As Single
Public bearingLOAD As Single
Public RNME As Single
Public TQOUTE As Single
Public RETE As Single
Public RETF As Single
Public RNMF As Single
Public TQOUTF As Single
Public unusedSPRINGturnsFORstretch As Single
Public availableSPRINGturnsFORstretch As Single
Public SID As Single
Public SOD As Single
Public RMOM As Single
Public maxWRAPSfromTORQUElift As Single
Public maxWRAPSfromTORQUEstretch As Single
Public EC As Single

Public maxFULLLAYERSfromTORQUEliftR As Single
Public extraWRAPSafterFULLLAYERStorqueLIFTr As Single
Public torqueACTIVEliftLENGTH As Single
Public maxLENGTHcableFROMtorqueLIFT As Single
Public maxFULLLAYERSfromTORQUEstretchR As Single
Public extraWRAPSafterFULLLAYERStorqueSTRETCHr As Single
Public torqueACTIVEstretchLENGTH As Single
Public maxLENGTHcableFROMtorqueSTRETCH As Single


Public malepipePN As String
Public malepipePRICE As Single
Public hoseclampPN As String
Public hoseclampPRICE As Single
Public hoseferrulePN As String
Public hoseferrulePRICE As Single

'CM calcs
Public defaultTMRwidth As String
Public defaultSHOwidth As String
Public swivelJOINTprice As Single

Public reelWIDTHinp As String
Public selectNUMBER As Integer
Public orderPOINTER As Integer 'contains the recnumber of the fest looking at
Public modelTYPEtoSTORE As Integer
Public reelPNTR As Integer  'points at the slot in which current reel is stored
Public optPNTR As Integer  'points at the slot in which options/accessories for current reel are stored


Public backTOsearch As Boolean
Public numREELquoted As Integer
Public momentARM As Single
Public pendantTORQUEftlb As Single
Public CBEND As Single
Public liftTORQUEftlb As Single
Public RA As Single
Public IXARR(1 To 50) As Integer
Public WRAP(1 To 50) As Single
Public Row(1 To 50) As Single

'from doINITIALcalcs
Public tempTORQUEcalc As Single
Public springTURNSavailFORreeling As Single  'CM has integer  SS
Public springTORQUEavailFORreeling As Single
Public maxWRAPSperLAYERi As Integer
Public extraWRAPSafterFULLLAYERSturnsi As Integer
Public maxWRAPSperLAYERrSTORED As Single
Public maxCABLElayersR As Single
Public maxCABLElayersI As Integer
Public maxUSABLElayersI As Integer
Public numberOFspringsI As Integer
Public springFAMILYindex As Integer
Public TURNSusedPERCENTstr As String
Public numberOFspringsR As Single
Public compartmentHEIGHT As Single
Public cableLAYERindexR As Single
Public cableLAYERindexI As Integer
Public compartmentCABLEcapacity As Single
Public layerCABLEcapacity As Single
Public cableCAPACITYlostFIRSTclearanceWRAP As Single
Public cableCAPACITYlostSECONDclearanceWRAP As Single
Public cableCAPACITYlostTHIRDclearanceWRAP As Single
Public cableCLEARANCEinINCHES As Single
Public cableCLEARANCEinINCHESless1layer As Single
Public cableCLEARANCEinINCHESless2layers As Single
Public cableCLEARANCEinINCHESless3layers As Single
Public RMOTI As Single
Public TQSIZ As Single
Public torqueFROMmotor As Single
Public diskweight As Single
Public wrapperweight As Single
Public shaftweight As Single
Public flangeweight As Single
Public reinforceweight As Single
Public totalWEIGHTlessCABLE As Single
Public totalINERTIA As Single
Public reelWIDTH As Single  'ss should this be single or integer
Public spoolWEIGHT As Single
Public coefficient As Single
Public maxTURNSfromSPRING As Integer

Public selREEL As Integer
Public reelINVALID As Boolean
Public validREELSfound As Boolean
Public CableCF As Single
Public cableCLEARANCEfactor As Single
Public collectorPRICE As Integer

Public calcDRUMminR As Single
Public calcDRUMminS As Integer
Public calcDRUMminSM As Integer
Public calcDRUMminMMD As Integer
Public calcDRUMminSHO As Integer
Public calcDRUMminTMR As Integer
Public calcDRUMminU As Integer
Public calcDRUMminP As Integer
Public calcDRUMmaxS As Integer
Public calcDRUMmaxSM As Integer
Public calcDRUMmaxMMD As Integer
Public calcDRUMmaxSHO As Integer
Public calcDRUMmaxTMR As Integer
Public calcDRUMmaxU As Integer
Public calcDRUMmaxP As Integer

Public maxTURNS As Single
Public maxTURNSfromSspring As Integer
Public maxTURNSfromSMspring As Integer
Public maxTURNSfromMMDspring As Integer
Public maxTURNSfromSHOspring As Integer
Public maxTURNSfromUspring As Integer
Public maxTURNSfromKspring As Integer
Public maxTURNSfromCMspring As Integer
Public maxTURNSfromHMspring As Integer
Public TURNSusedPERCENT As Integer


Public REELpriceMULTIPLIER As Single

Public modelCODE As Integer
Public Smodels As String 'For sub findTHEreel(), can be "All" or "Some"
Public Kmodels As String
Public SMmodels As String
Public MMDmodels As String
Public SHOmodels As String
Public TMRmodels As String
Public Umodels As String
Public CMmodels As String
Public HMmodels As String
Public Pmodels As String

Public SspringSEL As String 'For sub findTHEreel()
Public SgearSEL As String
Public ScollSEL As String
Public SdrumminSEL As String
Public SdrummaxSEL As String
Public SpreminSEL As String
Public SpremaxSEL As String

Public KspringSEL As String
Public KpreminSEL As String
Public KpremaxSEL As String

Public SMspringSEL As String
Public SMgearSEL As String
Public SMcollSEL As String
Public SMdrumminSEL As String
Public SMdrummaxSEL As String
Public SMpreminSEL As String
Public SMpremaxSEL As String

Public MMDspringSEL As String
Public MMDgearSEL As String
Public MMDcollSEL As String
Public MMDdrumminSEL As String
Public MMDdrummaxSEL As String
Public MMDpreminSEL As String
Public MMDpremaxSEL As String

Public SHOspoolmethodSEL As String
Public SHOspringSEL As String
Public SHOspoolwidthSEL As String
Public SHOspooldiamSEL As String
Public SHOchainratioSEL As String
Public SHOcollSEL As String
Public SHOdrumminSEL As String
Public SHOdrummaxSEL As String
Public SHOpreminSEL As String
Public SHOpremaxSEL As String

Public TMRspoolmethodSEL As String
Public TMRmotorSEL As String
Public TMRspoolwidthSEL As String
Public TMRspooldiamSEL As String
Public TMRchainratioSEL As String
Public TMRcollSEL As String
Public TMRdrumminSEL As String
Public TMRdrummaxSEL As String

Public UspringSEL As String
Public UgearSEL As String
Public UcollSEL As String
Public UdrumminSEL As String
Public UdrummaxSEL As String
Public UpreminSEL As String
Public UpremaxSEL As String

Public HMspringSEL As String
Public HMpreminSEL As String
Public HMpremaxSEL As String
Public CMspringSEL As String
Public CMcollSEL As String
Public CMpreminSEL As String
Public CMpremaxSEL As String

Public PmotorSEL As String
Public PcollSEL As String
Public PdrumminSEL As String
Public PdrummaxSEL As String

Public srchSTYLE As String
Public srchCOST As Single
Public srchFRAME As String
Public srchSPRING As String
Public srchSPOOLMETHOD As String
Public srchSPOOLWIDTH As String
Public srchSPOOLDIAM As String
Public srchGEAR As String
Public srchMOTOR As String
Public srchCOLL As String
Public srchDRUMMIN As String
Public srchDRUMMAX As String
Public srchPREMIN As String
Public srchPREMAX As String
Public spoolWIDTHcode As String

'** MODEL VARIABLES **
Public reelTYPE As String
Public frameSIZEdefault As String
Public frameSIZE As Single
Public springSIZE As Single
Public springSIZEdefault As String
Public validSPRING As Integer
Public calcDRUMmin As Integer
Public calcDRUMmax As Integer
Public drumDIAMmin As String
Public drumDIAMmax As String
Public drumSIZE As Single
Public gearCODE As String
Public gearRATIO As Single
Public gearRATIOstr As String
Public validGEAR As Integer
Public pretensionMIN As String
Public pretensionMAX As String
Public pretensionTURNno As Single
Public pretensionTURNS As Single

Public MODELnum As String

Public specificINPUT(0 To 8) As Single
Public validCOMPARTMENT As Integer
Public validTURNS As Integer
Public validTORQUE As Boolean
Public validSTRESS As Boolean
Public validDRUMmax As Integer
Public validPRETENSmax As Integer
Public validFRAME As Integer
Public frameOK As Integer

Public ADJmaxTURNSforFIRSTpartOFcurve   As Single
Public ADJslopeFIRSTpartOFcurve  As Single
Public ADJyinterceptFIRSTpartOFcurve   As Single
Public ADJmaxTURNSforSECONDpartOFcurve   As Single
Public ADJslopeSECONDpartOFcurve  As Single
Public ADJyinterceptSECONDpartOFcurve   As Single
Public ADJmaxTURNSforTHIRDpartOFcurve   As Single
Public ADJslopeTHIRDpartOFcurve  As Single
Public ADJyinterceptTHIRDpartOFcurve   As Single


Public specificMODELinput As Boolean  'flag set if inside sales is specifying exact model they want
Public newORmod As String
Public changeUNITSallowed As Boolean
Public custIDchecked As String


Public inputCOMPLETE As Boolean 'flags whether all inputs are done
Public repDATAinput As Boolean 'flags whether user has input his rep data - stored in setup file

Public cabSKIP As Boolean 'flags whether cable pkg input is skipped
Public modelCHANGES As Boolean 'flags whether user made changes to previouly entered model data

Public SframeLIST As String 'stores list of frames selected
Public SMframeLIST As String 'stores list of frames selected
Public MMDframeLIST As String 'stores list of frames selected
Public UframeLIST As String 'stores list of frames selected
Public CMframeLIST As String 'stores list of frames selected
Public PframeLIST As String 'stores list of frames selected
Public KframeLIST As String
Public HMframeLIST As String 'stores list of frames selected

Public noneVALID As Boolean  'flags whether any valid reels found
Public DataDB As String 'stores path & filename
Public BmpPath As String 'stores path of bmp's
Public runQUOTE As Boolean 'flags whether quote can be run (cutomer input or not)
Public mod1FLAG As Boolean 'flags whether model 1 screen completed
Public mod2FLAG As Boolean 'flags whether model 2 screen completed
Public cabFLAG As Boolean 'flags whether cable screen completed
Public appFLAG As Boolean 'flags whether application screen completed
Public custFLAG As Boolean 'flags whether customer screen completed

Public recNUMBER As Integer  'stores number of record we are on in array of valid reels
Public delCUSTID As String  'stores customer id for customer to delete
Public delCUSTNAME As String 'stores name to be deleted
Public reassignCUSTID As String 'stores ID to reassign to
Public reassignCUSTNAME As String 'stores name to reassign to
Public numberMODELStoRETURN As Integer  'store number of models to return if user selects "any"
Public trakAPPLICATION As String  'needed in all programs

'** APPLICATION VARIABLES **
Public activeTRAVEL As Single
Public inpAPPLICATION As String
Public reelAPPLICATION As String
Public dutyCYCLE As Long
Public ambTEMPmin As Integer
Public ambTEMPmax As Integer
Public systemSPEED As Single
Public systemACCEL As Single
Public pendantWEIGHT As Single
Public percentSAG As Single
Public percentSAGstr As String
Public SAGfactor As Single
Public centerlineHEIGHT As Single
Public deadWRAPS As Integer


'metver - new variables - search for them throughout
Public travelINft As Single
Public speedINftsec As Single
Public accelINftsecsec As Single
Public centerlineINft As Single
Public pendantINlbs As Single


Dim searchDB As Database, searchRS As Recordset
Dim Best2 As Boolean  'flags whether or not the best two solutions for a given series/carrier have been found

'** check flags **
Dim validWIDTH As Boolean  'flag indicating if WIDTH valid
Dim validHEIGHT As Boolean  'flag indicating if HEIGHT valid
Dim validTRAVEL As Boolean  'flag indicating if TRAVEL valid
Dim validSPEED As Boolean 'flag indicating if SPEED valid
Dim notRECOMMENDEDflag As Boolean  'flag if model will work but not recommended.
Dim validPRICEfound As Boolean  'flags TRUE if price found, FALSE if not (overwrite array with next)

'** DATABASE READ VARIABLES **
'the following are filled with data from database when a validREEL is found

Public extraCABLEatREEL As Integer

Public modelWEIGHT As Integer
Public dimensWIDTH As Single
Public dimensHEIGHT As Single
Public dimensDEPTH As Single

Public cheatONdrumWRAPPERDIA As Integer
Public MINdrumWRAPPERDIAr As Single
Public MINdrumWRAPPERDIAi As Integer
Public wrapperWIDTHi As Integer

Public wrapperWIDTHr As Single
Public maxWRAPSperLAYERr As Single
Public maxCABLEwrapsI As Integer
'?Public maxDRUMwrapperDIAi As Integer
Public maxUSABLElayersR As Single
Public maxUSABLEwrapsR As Single

Public reelTOTALlistPrice As Integer

Public availSPRINGturns As Single
Public netTORQUEwithREELfullLIFT As Single
Public maxACTIVElengthOFcableFROMtorqueLIFT As Single
Public maxLIFTcapacityOFreel As Single

Public netTORQUEwithREELfullSTRETCH As Single
Public maxACTIVElengthOFcableFROMtorqueSTRETCH As Single
Public maxSTRETCHcapacityOFreel As Single

Public netTORQUEwithREELfullRETRIEVE As Single
Public maxCENTERLINEheight As Single
Public maximumRETRIEVEcapacityOFreel As Single

Public deadWRAPlength As Single
Public compartmentACTIVEcableLENGTH As Single
Public compartmentMAXIMUMcableLENGTH As Single
Public springTURNSavailAFTERpretensionR As Single
Public springTURNSavailAFTERpretensionI As Integer
Public maxFULLLAYERSfromTURNSr As Single
Public maxFULLLAYERSfromTURNSi As Integer
Public extraWRAPSafterFULLLAYERSturnsr As Single
Public turnsMAXIMUMcableLENGTH As Single
Public turnsACTIVEcableLENGTH As Single

Public torqueTOovercomeCOLLECTORfriction As Single

Public reelINERTIA As Single

Public firstLAYERmomentARM As Single
Public torqueSAFETYfactor As Single
Public adjustedTORQUE As Single
Public tempTURNS As Single



'?Public extraWRAPSafterFULLLAYERStorqueLIFTi As Integer


Public reelQTY As String
Public optQUOTECABLEresp As Integer
Public optQUOTECABLEextralength As String

Public optCABLEINSTALLresp  As Integer

Public rollerguidePN As String
Public rollerguidePRICE As Single
Public hoopguidePN As String
Public hoopguidePRICE As Single
Public limitswitchPN As String
Public limitswitchPRICE As Single
Public pivotbasePN As String
Public pivotbasePRICE As Single
Public dogratchetPN As String
Public dogratchetPRICE As Single
Public spoollockPN As String
Public spoollockPRICE As Single
Public ballstopPN As String
Public ballstopPRICE As Single
Public cablegripPN As String
Public cablegripPRICE As Single










Public Function modelNO()
Dim modelSTR As String
Dim uMODELsuffix As String
Dim drumSTR As String

Select Case srchSTYLE
   Case "S", "SM", "MMD":
      If srchSTYLE = "S" And Val(srchFRAME) > 15 And Val(srchFRAME) < 25 And SWopt Then
        modelSTR = "SW" & srchFRAME & srchSPRING & "-" & srchCOLL & "-" & Trim(Str(drumSIZE)) & "-"
      Else
        modelSTR = srchSTYLE & srchFRAME & srchSPRING & "-" & srchCOLL & "-" & Trim(Str(drumSIZE)) & "-"
      End If
     If Len(Trim(srchGEAR)) > 0 Then
       modelSTR = modelSTR & srchGEAR & "-"
     End If
     modelSTR = modelSTR & Trim(Str(pretensionTURNS))
   Case "K":
     modelSTR = srchSTYLE & srchFRAME & srchSPRING & "-" & hoseIDcode & "-" & Trim(Str(pretensionTURNS))
   Case "U":
     Select Case cableORhose
       Case "HS", "HD": uMODELsuffix = "H"
       Case Else:  uMODELsuffix = "E"
     End Select
     drumSTR = Trim(Str(drumSIZE))
     If Len(drumSTR) = 1 Then drumSTR = "0" & drumSTR
     modelSTR = srchSTYLE & uMODELsuffix & srchFRAME & srchSPRING & "-" & srchCOLL & "-" & drumSTR & reelWIDTHinp & "-"
      If Len(Trim(srchGEAR)) > 0 Then
       modelSTR = modelSTR & srchGEAR & "-"
     End If
     modelSTR = modelSTR & Trim(Str(pretensionTURNS))
   Case "SHO":
     modelSTR = srchSTYLE & srchSPRING & "-" & srchCOLL & "-" & Trim(Str(drumSIZE))
     If srchSPOOLMETHOD = "M" Then
       modelSTR = modelSTR & spoolWIDTHcode & srchFRAME & "-" & srchGEAR & "-" & Trim(Str(pretensionTURNS))
     Else
       modelSTR = modelSTR & srchSPOOLWIDTH & srchFRAME & "-" & srchGEAR & "-" & Trim(Str(pretensionTURNS))
     End If
   Case "TMR":
     modelSTR = srchSTYLE & srchCOLL & "-" & Trim(Str(drumSIZE))
     If srchSPOOLMETHOD = "M" Then
      modelSTR = modelSTR & spoolWIDTHcode & srchFRAME & "-" & srchGEAR & "-" & srchMOTOR
     Else
       modelSTR = modelSTR & srchSPOOLWIDTH & srchFRAME & "-" & srchGEAR & "-" & srchMOTOR
     End If
   Case "C":
     'If srchSPRING = "U" Or srchSPRING = "V" Then
     '  modelSTR = srchSTYLE & srchFRAME & "-" & srchCOLL & "-EZ11" & "0" & Trim(Str(pretensionTURNS))
     'Else
       modelSTR = srchSTYLE & srchFRAME & "-" & srchCOLL & "-" & srchSPRING & "11" & "0" & Trim(Str(pretensionTURNS))
    ' End If
   Case "HM":
     'If srchSPRING = "U" Or srchSPRING = "V" Then
     '  modelSTR = srchSTYLE & srchFRAME & "-EZ" & "-" & hoseIDcode & "-P" & Trim(Str(pretensionTURNS))
     'Else
       modelSTR = srchSTYLE & srchFRAME & srchSPRING & "-" & hoseIDcode & "-P" & Trim(Str(pretensionTURNS))
     'End If
   Case "P":
     modelSTR = srchSTYLE & srchFRAME & "-" & srchCOLL & "-" & Trim(Str(drumSIZE)) & "-" & srchMOTOR

 End Select

modelNO = modelSTR


End Function






Public Sub calcREELprice()

reelTOTALlistPrice = 0
Dim inputVAL As String

If cableORhose = "HS" Then  'either U or HM
  swivelJOINTprice = 0
  If srchSTYLE = "U" Then
    Select Case hoseIDcode
      Case "4": swivelJOINTprice = 101  '2013 prices
      Case "6": swivelJOINTprice = 101
      Case "8": swivelJOINTprice = 101
      Case "12": swivelJOINTprice = 139
      Case "16": swivelJOINTprice = 173
      Case "20": swivelJOINTprice = 283
      Case "24": swivelJOINTprice = 662
    End Select
  End If
  collectorPRICE = -2
Else
  Call lookupCOLLECTORprice  'will return -2 for C, K and HM
  swivelJOINTprice = 0
End If


If collectorPRICE > 0 Then  'all cable reels
  reelTOTALlistPrice = Val(srchCOST) + collectorPRICE
ElseIf collectorPRICE = -2 Then  'for those without collectors it will be -2
  reelTOTALlistPrice = Val(srchCOST) + swivelJOINTprice
ElseIf collectorPRICE = 0 Or collectorPRICE = -1 Then  'collector price not found, we can't quote
  If securityCODE = 99 Then 'inside sales
line99:
   inputVAL = InputBox(srchSTYLE & "-reel collector price for " & srchCOLL & " not found. In order to quote, please enter a price for the collector:", "collector Price Not Found", "")
   If Val(inputVAL) > 20000 Or Not IsNumeric(inputVAL) Then GoTo line99
   collectorPRICE = inputVAL
   reelTOTALlistPrice = Val(srchCOST) + collectorPRICE
  Else
    reelTOTALlistPrice = 0: Exit Sub
  End If

End If

If srchSTYLE = "S" And Val(srchFRAME) > 15 And Val(srchFRAME) < 25 And SWopt Then reelTOTALlistPrice = reelTOTALlistPrice + 173.2 '2013 adder for SW option  manually bump

If srchSTYLE = "U" Then  'need adders for spool width
  Select Case Val(reelWIDTHinp)  '2013 prices
    Case 6: reelTOTALlistPrice = reelTOTALlistPrice + 0
    Case 8: reelTOTALlistPrice = reelTOTALlistPrice + 24
    Case 10: reelTOTALlistPrice = reelTOTALlistPrice + 49
    Case 12: reelTOTALlistPrice = reelTOTALlistPrice + 70
    Case 14: reelTOTALlistPrice = reelTOTALlistPrice + 94
    Case Else: reelTOTALlistPrice = 0
  End Select
End If


End Sub


Public Sub checkFORSPECIFICinput()
'this subroutine checks to see if inside sales has specified a particular
'model.  If they have, they know what they want so we will set a flag
'allowing them to override the validity checks and quote a potentially invalid model
Dim i As Integer

Select Case cableORhose
  Case "HS", "HD":
    'check for specific K reel
    For i = 2 To 6
     If Model2!SSCheck4(i) Then
       If UCase(Model2!Combo1) <> "ALL" Then
         If Model2!Text4 = Model2!Text5 Then
           specificINPUT(7) = True
         End If
       End If
      End If
     Next i
    'check for specific U reel
   For i = 2 To 6
     If Model2!SSCheck8(i) Then
       If UCase(Model2!Combo8) <> "ALL" And UCase(Model2!Combo9) <> "ALL" Then
         If Model2!Text17 = Model2!Text18 And Model2!Text22 = Model2!Text23 Then
           specificINPUT(5) = True
         End If
       End If
     End If
   Next i
   'check for specific HM reel
   For i = 2 To 4
     If Model2!SSCheck7(i) Then
       If UCase(Model2!Combo7) <> "ALL" Then
         If Model2!Text19 = Model2!Text20 Then
           specificINPUT(8) = True
         End If
       End If
     End If
   Next i
  Case Else:
    'check for specific S reel
    For i = 2 To 8
     If Model1!SSCheck4(i) Then
       If UCase(Model1!Combo1) <> "ALL" And UCase(Model1!Combo2) <> "ALL" Then
         If Model1!Text1 = Model1!Text3 And Model1!Text4 = Model1!Text5 Then
           specificINPUT(1) = True
         End If
       End If
     End If
   Next i

   'check for specific MMD reel
   For i = 2 To 5
     If Model1!SSCheck6(i) Then
       If UCase(Model1!Combo5) <> "ALL" And UCase(Model1!Combo6) <> "ALL" Then
         If Model1!Text12 = Model1!Text13 And Model1!Text14 = Model1!Text15 Then
           specificINPUT(2) = True
         End If
       End If
     End If
   Next i

   'check for specific SM reel
   For i = 2 To 5
     If Model1!SSCheck5(i) Then
       If UCase(Model1!Combo3) <> "ALL" And UCase(Model1!Combo4) <> "ALL" Then
         If Model1!Text7 = Model1!Text8 And Model1!Text9 = Model1!Text10 Then
           specificINPUT(3) = True
         End If
       End If
     End If
   Next i

   'check for specific CM reel
   For i = 2 To 4
     If Model1!SSCheck7(i) Then
       If UCase(Model1!Combo7) <> "ALL" Then
         If Model1!Text19 = Model1!Text20 Then
           specificINPUT(4) = True
         End If
       End If
     End If
   Next i

   'check for specific U reel
   For i = 2 To 6
     If Model1!SSCheck8(i) Then
       If UCase(Model1!Combo8) <> "ALL" And UCase(Model1!Combo9) <> "ALL" Then
         If Model1!Text17 = Model1!Text18 And Model1!Text22 = Model1!Text23 Then
           specificINPUT(5) = True
         End If
       End If
     End If
   Next i

   'check for specific P reel
   For i = 2 To 8
     If Model1!SSCheck9(i) Then
       If UCase(Model1!Combo10) <> "ALL" Then
         If Model1!Text25 = Model1!Text26 Then
           specificINPUT(6) = True
         End If
       End If
     End If
   Next i
End Select
End Sub




Public Sub loadREELquote()



End Sub



Public Sub calcMODELweight()
Dim testSTR As String
KdimensA = 0
modelWEIGHT = 0
Select Case srchSTYLE
  Case "S", "MMD":
    If srchSTYLE = "S" Then modelWEIGHT = 85          'initialize base model weight
    If srchSTYLE = "MMD" Then modelWEIGHT = 115       'initialize base model weight
    Select Case srchSPRING
      Case "351":  modelWEIGHT = modelWEIGHT + 0
      Case "601":  modelWEIGHT = modelWEIGHT + 5
      Case "621":  modelWEIGHT = modelWEIGHT + 25
      Case "622":  modelWEIGHT = modelWEIGHT + 75
      Case "623":  modelWEIGHT = modelWEIGHT + 125
      Case "624":  modelWEIGHT = modelWEIGHT + 175
      Case "751":  modelWEIGHT = modelWEIGHT + 10
      Case "752":  modelWEIGHT = modelWEIGHT + 60
      Case "753":  modelWEIGHT = modelWEIGHT + 110
      Case "754":  modelWEIGHT = modelWEIGHT + 160
      Case "801":  modelWEIGHT = modelWEIGHT + 40
      Case "802":  modelWEIGHT = modelWEIGHT + 95
      Case "803":  modelWEIGHT = modelWEIGHT + 150
      Case "804":  modelWEIGHT = modelWEIGHT + 205
      Case "1001": modelWEIGHT = modelWEIGHT + 50
      Case "1002": modelWEIGHT = modelWEIGHT + 110
      Case "1003": modelWEIGHT = modelWEIGHT + 170
      Case "1004": modelWEIGHT = modelWEIGHT + 230
    End Select
    Select Case srchFRAME
      Case "14":  modelWEIGHT = modelWEIGHT + 0
      Case "16":  modelWEIGHT = modelWEIGHT + 10
      Case "18":  modelWEIGHT = modelWEIGHT + 20
      Case "21":  modelWEIGHT = modelWEIGHT + 30
      Case "24":  modelWEIGHT = modelWEIGHT + 40
      Case "28":  modelWEIGHT = modelWEIGHT + 55
      Case "32":
        Select Case srchSPRING
          Case "801": modelWEIGHT = 200
          Case "802": modelWEIGHT = 260
          Case "803": modelWEIGHT = 320
          Case "804": modelWEIGHT = 380
          Case "1001": modelWEIGHT = 210
          Case "1002": modelWEIGHT = 275
          Case "1003": modelWEIGHT = 340
          Case "1004": modelWEIGHT = 410
        End Select
    End Select
    'take into account geared reel weight
    If srchSTYLE = "S" And gearRATIO <> 1 Then modelWEIGHT = modelWEIGHT + 25

    If srchSTYLE = "MMD" And gearRATIO <> 1 Then
      Select Case srchFRAME
       Case "21":  modelWEIGHT = modelWEIGHT + 25
       Case "24":  modelWEIGHT = modelWEIGHT + 25
       Case "28":  modelWEIGHT = modelWEIGHT + 30
       Case "32":  modelWEIGHT = modelWEIGHT + 30
      End Select
    End If

  Case "SM"
    modelWEIGHT = 395
    Select Case srchSPRING
      Case "1001": modelWEIGHT = modelWEIGHT + 0
      Case "1002": modelWEIGHT = modelWEIGHT + 65
      Case "1003": modelWEIGHT = modelWEIGHT + 130
      Case "1004": modelWEIGHT = modelWEIGHT + 195
    End Select
    Select Case srchFRAME
      Case "21":  modelWEIGHT = modelWEIGHT + 0
      Case "24":  modelWEIGHT = modelWEIGHT + 10
      Case "28":  modelWEIGHT = modelWEIGHT + 85
      Case "32":
        Select Case srchSPRING
          Case "1001": modelWEIGHT = 550
          Case "1002": modelWEIGHT = 600
          Case "1003": modelWEIGHT = 650
          Case "1004": modelWEIGHT = 700
          Case "1005": modelWEIGHT = 800
          Case "1006": modelWEIGHT = 850
          Case "1007": modelWEIGHT = 930
          Case "1008": modelWEIGHT = 980
        End Select
    End Select
  Case "U"
    modelWEIGHT = 0
    If gearRATIO <> 1 Then
      Select Case cableORhose
        Case "HD", "HS":  'hoses
          Select Case srchFRAME
            Case "24":  modelWEIGHT = modelWEIGHT + 155
            Case "28":  modelWEIGHT = modelWEIGHT + 170
            Case "32":  modelWEIGHT = modelWEIGHT + 195
          End Select
        Case Else
          Select Case srchFRAME
            Case "24":  modelWEIGHT = modelWEIGHT + 160
            Case "28":  modelWEIGHT = modelWEIGHT + 175
            Case "32":  modelWEIGHT = modelWEIGHT + 200
          End Select
      End Select
    Else
      Select Case cableORhose
        Case "HD", "HS":  'hoses
          Select Case srchFRAME
            Case "18":  modelWEIGHT = modelWEIGHT + 84
            Case "21":  modelWEIGHT = modelWEIGHT + 91
            Case "24":  modelWEIGHT = modelWEIGHT + 100
            Case "28":  modelWEIGHT = modelWEIGHT + 115
            Case "32":  modelWEIGHT = modelWEIGHT + 140
          End Select
        Case Else
          Select Case srchFRAME
            Case "18":  modelWEIGHT = modelWEIGHT + 91
            Case "21":  modelWEIGHT = modelWEIGHT + 95
            Case "24":  modelWEIGHT = modelWEIGHT + 105
            Case "28":  modelWEIGHT = modelWEIGHT + 120
            Case "32":  modelWEIGHT = modelWEIGHT + 145
          End Select
      End Select
    End If
    Select Case srchSPRING
      Case "351":  modelWEIGHT = modelWEIGHT + 20
      Case "621":  modelWEIGHT = modelWEIGHT + 40
      Case "622":  modelWEIGHT = modelWEIGHT + 80
      Case "751":  modelWEIGHT = modelWEIGHT + 33
      Case "752":  modelWEIGHT = modelWEIGHT + 66
      Case "801":  modelWEIGHT = modelWEIGHT + 44
      Case "802":  modelWEIGHT = modelWEIGHT + 88
      Case "1001": modelWEIGHT = modelWEIGHT + 64
      Case "1002": modelWEIGHT = modelWEIGHT + 129
    End Select
  Case "HM":
    Select Case srchFRAME
    Case "14":
      Select Case srchSPRING
        Case "1": modelWEIGHT = 30
        Case "2": modelWEIGHT = 32
        Case "3": modelWEIGHT = 42
        Case "U": modelWEIGHT = 42
      End Select
    Case "16":
      Select Case srchSPRING
        Case "4": modelWEIGHT = 63 'estimated
        Case "5": modelWEIGHT = 51 'estimated
        Case "7": modelWEIGHT = 53 'estimated
        Case "8": modelWEIGHT = 56 'estimated
        Case "10": modelWEIGHT = 62 'estimated
        Case "11": modelWEIGHT = 62 'estimated
        Case "V": modelWEIGHT = 62 'estimated
      End Select
    Case "19":
      Select Case srchSPRING
        Case "4": modelWEIGHT = 75
        Case "5": modelWEIGHT = 58
        Case "7": modelWEIGHT = 60 'estimated
        Case "8": modelWEIGHT = 65 'estimated
        Case "10": modelWEIGHT = 74 'estimated
        Case "11": modelWEIGHT = 74 'estimated
        Case "V": modelWEIGHT = 74 'estimated
      End Select
    End Select
  Case "C":
   Select Case srchFRAME
    Case "14":
      Select Case srchSPRING
        Case "A": modelWEIGHT = 40
        Case "B": modelWEIGHT = 42
        Case "C": modelWEIGHT = 47
        Case "U": modelWEIGHT = 47
      End Select
    Case "16":
      Select Case srchSPRING
        Case "D": modelWEIGHT = 78
        Case "E": modelWEIGHT = 59
        Case "G": modelWEIGHT = 65
        Case "H": modelWEIGHT = 68
        Case "J": modelWEIGHT = 75
        Case "K": modelWEIGHT = 75
        Case "V": modelWEIGHT = 75
      End Select
    Case "19":
      Select Case srchSPRING
        Case "D": modelWEIGHT = 89
        Case "E": modelWEIGHT = 70
        Case "G": modelWEIGHT = 73
        Case "H": modelWEIGHT = 78
        Case "J": modelWEIGHT = 86
        Case "K": modelWEIGHT = 76
        Case "V": modelWEIGHT = 86
      End Select
    End Select
  Case "P"
    modelWEIGHT = 129          'initialize base model weight
    Select Case srchMOTOR
      Case "25":  modelWEIGHT = modelWEIGHT + 0
      Case "50":  modelWEIGHT = modelWEIGHT + 16
      Case "75":  modelWEIGHT = modelWEIGHT + 50
      Case "150":  modelWEIGHT = modelWEIGHT + 62
    End Select
    Select Case srchFRAME
      Case "14":  modelWEIGHT = modelWEIGHT + 0
      Case "16":  modelWEIGHT = modelWEIGHT + 5
      Case "18":  modelWEIGHT = modelWEIGHT + 15
      Case "21":  modelWEIGHT = modelWEIGHT + 25
      Case "24":  modelWEIGHT = modelWEIGHT + 50
      Case "28":  modelWEIGHT = modelWEIGHT + 65
      Case "32":  modelWEIGHT = modelWEIGHT + 90
    End Select
  Case "SHO":
    Select Case srchSPRING
      Case "801":  modelWEIGHT = 485
      Case "802":  modelWEIGHT = 530
      Case "803":  modelWEIGHT = 580
      Case "804":  modelWEIGHT = 625
      Case "1001": modelWEIGHT = 595
      Case "1002": modelWEIGHT = 655
      Case "1003": modelWEIGHT = 715
      Case "1004": modelWEIGHT = 775
      Case "1005": modelWEIGHT = 1035
      Case "1006": modelWEIGHT = 1095
      Case "1007": modelWEIGHT = 1155
      Case "1008": modelWEIGHT = 1215
    End Select
  Case "TMR":
    Select Case srchMOTOR
      Case "2":  modelWEIGHT = 585
      Case "3":  modelWEIGHT = 600
      Case "5":  modelWEIGHT = 615
      Case "7":  modelWEIGHT = 630
      Case "9":  modelWEIGHT = 645
      Case "14":  modelWEIGHT = 660
    End Select
  Case "K":
    testSTR = Trim(srchFRAME) + Trim(srchSPRING) + Trim(hoseIDcode)
    Select Case testSTR
      Case "183514":  modelWEIGHT = 115: KdimensA = 12.12
      Case "187514":  modelWEIGHT = 120: KdimensA = 12.62
      Case "217514":  modelWEIGHT = 130: KdimensA = 12.62
      Case "247514":  modelWEIGHT = 140: KdimensA = 12.62
      Case "287514":  modelWEIGHT = 150: KdimensA = 12.62
      Case "2810014":  modelWEIGHT = 160: KdimensA = 13.62
      Case "328024":  modelWEIGHT = 235: KdimensA = 15
      Case "3210014":  modelWEIGHT = 180: KdimensA = 13.62
      Case "187516":  modelWEIGHT = 120: KdimensA = 13.12
      Case "213516":  modelWEIGHT = 115: KdimensA = 12.62
      Case "217516":  modelWEIGHT = 130: KdimensA = 13.12
      Case "247516":  modelWEIGHT = 140: KdimensA = 13.12
      Case "287516":  modelWEIGHT = 155: KdimensA = 13.12
      Case "2810016":  modelWEIGHT = 165: KdimensA = 14.12
      Case "327526": modelWEIGHT = 225: KdimensA = 15.5
      Case "327536": modelWEIGHT = 280: KdimensA = 17.88
      Case "3210016": modelWEIGHT = 180: KdimensA = 14.12
      Case "187518": modelWEIGHT = 120: KdimensA = 13.5
      Case "217518":  modelWEIGHT = 130: KdimensA = 13.5
      Case "247518":  modelWEIGHT = 140: KdimensA = 13.5
      Case "2410018":  modelWEIGHT = 150: KdimensA = 14.5
      Case "287518":  modelWEIGHT = 155: KdimensA = 13.5
      Case "2810018":  modelWEIGHT = 165: KdimensA = 14.5
      Case "327528":  modelWEIGHT = 225: KdimensA = 15.88
      Case "327538":  modelWEIGHT = 280: KdimensA = 18.25
      Case "3210018":  modelWEIGHT = 180: KdimensA = 14.5
      Case "24100112":  modelWEIGHT = 160: KdimensA = 16.77
      Case "2875312":  modelWEIGHT = 275: KdimensA = 20.56
      Case "28100112":  modelWEIGHT = 175: KdimensA = 16.77
      Case "3275312": modelWEIGHT = 290: KdimensA = 20.56
      Case "3275412": modelWEIGHT = 350: KdimensA = 22.88
      Case Else: modelWEIGHT = 0: KdimensA = 0
    End Select
End Select
End Sub



Public Sub calcMODELdimensions()
Dim dimensA As Single
Dim dimensB As Single
Dim dimensC As Single
Dim dimensD As Single
Dim dimensE As Single
Dim dimensZ As Single

dimensDEPTH = 0
dimensWIDTH = 0
dimensHEIGHT = 0

Select Case srchSTYLE         'determine height and width
  Case "S", "MMD":
    Select Case LTrim$(RTrim$(collectorCODE))
      Case "23", "33", "43": dimensA = 15!
      Case "63", "83", "27", "37", "47", "212", "220", "320", "420": dimensA = 17.5
      Case "67", "103", "123", "312": dimensA = 20!
      Case "87", "143", "163", "412": dimensA = 22.5
      Case "203", "243": dimensA = 27.5
      Case "303", "363": dimensA = 35.5
    End Select

    If srchFRAME = "14" Then dimensA = dimensA - 0.5
    If srchFRAME = "28" Or srchFRAME = "32" Then dimensA = dimensA + 1!
    If srchSTYLE = "S" And Val(srchFRAME) > 15 And Val(srchFRAME) < 25 And SWopt Then dimensA = dimensA + 2 'two extra inches added to spool width

    Select Case srchSPRING
      Case "351", "601":  dimensB = 7.1
      Case "621", "751", "801":  dimensB = 7.62
      Case "622", "752", "802":  dimensB = 10.25
      Case "623", "753", "803":  dimensB = 12.88
      Case "624", "754", "804": dimensB = 15.5
      Case "1001":  dimensB = 8.5
      Case "1002":  dimensB = 11.88
      Case "1003":  dimensB = 15.25
      Case "1004":  dimensB = 18.62
    End Select

    If srchFRAME = "14" Then dimensB = dimensB - 0.5
    If srchFRAME = "28" Then dimensB = dimensB + 1!
    If gearRATIO <> 1 Then
      If srchFRAME <> "32" Then
        dimensB = dimensB + 5
      Else
        Select Case srchSPRING   'special s32 frame dimensions added 6/97
          Case "801":  dimensB = 14.38
          Case "802":  dimensB = 17.88
          Case "803":  dimensB = 21.38
          Case "804": dimensB = 24.88
          Case "1001":  dimensB = 15.25
          Case "1002":  dimensB = 18.75
          Case "1003":  dimensB = 22.25
          Case "1004":  dimensB = 25.75
        End Select
     End If
   End If
   dimensWIDTH = dimensA + dimensB

   Select Case srchSTYLE         'determine height and width
    Case "S":
     Select Case srchFRAME
      Case "14": dimensHEIGHT = 16.5: dimensDEPTH = 13.5
      Case "16": dimensHEIGHT = 18.5: dimensDEPTH = 16!
      Case "18": dimensHEIGHT = 20!: dimensDEPTH = 18!
      Case "21": dimensHEIGHT = 23!: dimensDEPTH = 21!
      Case "24": dimensHEIGHT = 26!: dimensDEPTH = 24!
      Case "28": dimensHEIGHT = 30!: dimensDEPTH = 28!
      Case "32": dimensHEIGHT = 34!: dimensDEPTH = 32!
     End Select
    Case "MMD":
     Select Case srchFRAME
      Case "21": dimensHEIGHT = 24.34: dimensDEPTH = 23.68
      Case "24": dimensHEIGHT = 27.34: dimensDEPTH = 26.68
      Case "28": dimensHEIGHT = 31.34: dimensDEPTH = 30.68
      Case "32": dimensHEIGHT = 35.34: dimensDEPTH = 34.68
     End Select
    End Select

  Case "SM":
    Select Case LTrim$(RTrim$(collectorCODE))
      Case "23", "33", "43", "63", "83", "27", "37", "47", "212": dimensA = 20.75
      Case "67", "87", "103", "123", "312", "412": dimensA = 23.75
      Case "143", "163", "220": dimensA = 25.75
      Case "320", "420": dimensA = 30.25
    End Select

    If Val(srchFRAME) > 24 Then dimensA = dimensA + 1!

    Select Case srchSPRING
      Case "1001":  dimensB = 14.88
      Case "1002":  dimensB = 18.25
      Case "1003":  dimensB = 21.62
      Case "1004":  dimensB = 25!
      Case "1005":  dimensB = 22.62
      Case "1006":  dimensB = 22.62
      Case "1007":  dimensB = 26!
      Case "1008":  dimensB = 26!
    End Select
    If Val(srchFRAME) > 24 And Val(srchSPRING) <= 1004 Then dimensB = dimensB + 1!

    Select Case srchFRAME
      Case "21": dimensHEIGHT = 27.88: dimensDEPTH = 25!
      Case "24": dimensHEIGHT = 29.38: dimensDEPTH = 28!
      Case "28": dimensHEIGHT = 32!: dimensDEPTH = 32!
      Case "32": dimensHEIGHT = 36!: dimensDEPTH = 36!
    End Select
    dimensWIDTH = dimensA + dimensB

  Case "U":
    Select Case Val(reelWIDTHinp)
      Case 4: dimensA = 8.5
      Case 6: dimensA = 10.5
      Case 8: dimensA = 12.5
      Case 10: dimensA = 14.5
      Case 12: dimensA = 16.5
      Case 14: dimensA = 18.5
    End Select

    Select Case srchSPRING
      Case "351": dimensE = 2.5
      Case "621": dimensE = 3
      Case "622": dimensE = 5.63
      Case "751": dimensE = 3
      Case "752": dimensE = 5.63
      Case "801": dimensE = 3
      Case "802": dimensE = 5.63
      Case "1001": dimensE = 4
      Case "1002": dimensE = 7.62
    End Select

    Select Case cableORhose
      Case "HD", "HS":  'hoses
        Select Case hoseIDcode
          Case "4": dimensC = 3
          Case "6": dimensC = 3!
          Case "8": dimensC = 3.12
          Case "12": dimensC = 3.25
          Case "16": dimensC = 4.12
          Case "20": dimensC = 4.36
          Case "24": dimensC = 6.5
        End Select
      Case Else:
        Select Case LTrim$(RTrim$(collectorCODE))
         Case "363": dimensC = 31.5
         Case "303": dimensC = 31.5
         Case "243": dimensC = 23.5
         Case "203": dimensC = 23.5
         Case "163": dimensC = 18.5
         Case "143": dimensC = 18.5
         Case "123": dimensC = 16
         Case "103": dimensC = 16
         Case "83": dimensC = 13.5
         Case "63": dimensC = 13.5
         Case "43": dimensC = 11
         Case "33": dimensC = 11
         Case "23": dimensC = 11
         Case "87": dimensC = 18.5
         Case "67": dimensC = 16
         Case "47": dimensC = 13.5
         Case "37": dimensC = 13.5
         Case "27": dimensC = 13.5
         Case "412": dimensC = 18.5
         Case "312": dimensC = 16!
         Case "212": dimensC = 13.5
         Case "420": dimensC = 13.5
         Case "320": dimensC = 13.5
         Case "220": dimensC = 13.5
         Case "440": dimensC = 0
         Case "340": dimensC = 0
         Case "240": dimensC = 0
         Case "47-13": dimensC = 13.5
         Case "37-13": dimensC = 13.5
         Case "412-13": dimensC = 18.5
         Case "312-13": dimensC = 16
         Case "420-13": dimensC = 13.5
         Case "320-13": dimensC = 13.5
         Case "440-13": dimensC = 0
         Case "340-13": dimensC = 0
      End Select
   End Select
   Select Case srchFRAME
     Case "18": dimensHEIGHT = 24.25: dimensDEPTH = 19!
     Case "21": dimensHEIGHT = 25.75: dimensDEPTH = 21!
     Case "24": dimensHEIGHT = 28!: dimensDEPTH = 24!
     Case "28": dimensHEIGHT = 32!: dimensDEPTH = 28!
     Case "32": dimensHEIGHT = 36!: dimensDEPTH = 32!
   End Select
   dimensWIDTH = dimensA + dimensC + dimensE
 Case "K":
   dimensWIDTH = KdimensA
   Select Case srchFRAME
      Case "18":  dimensHEIGHT = 19.75: dimensDEPTH = 18!
      Case "21": dimensHEIGHT = 23!: dimensDEPTH = 21!
      Case "24": dimensHEIGHT = 26!: dimensDEPTH = 24!
      Case "28": dimensHEIGHT = 30!: dimensDEPTH = 28!
      Case "32": dimensHEIGHT = 34!: dimensDEPTH = 32!
    End Select
 Case "C":
  Select Case srchFRAME
    Case "14":
      Select Case Left(srchCOLL, 1)
        Case "A", "B", "C", "D", "Z":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 12.19
            Case "05", "06", "07", "08": dimensWIDTH = 13.69
            Case "09", "10", "11", "12": dimensWIDTH = 15.19
            Case Else:  dimensWIDTH = 0
          End Select
        Case "E", "F":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 13.69
            Case Else:  dimensWIDTH = 0
          End Select
      End Select
    Case "16"
      Select Case Left(srchCOLL, 1)
        Case "A", "B", "C", "D", "Z":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 14.19
            Case "05", "06", "07", "08": dimensWIDTH = 15.69
            Case "09", "10", "11", "12": dimensWIDTH = 17.19
            Case Else:  dimensWIDTH = 0
          End Select
        Case "E", "F":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 15.69
            Case Else:  dimensWIDTH = 0
          End Select
      End Select
    Case "19":
      Select Case Left(srchCOLL, 1)
        Case "A", "B", "C", "D", "Z":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 13.94
            Case "05", "06", "07", "08": dimensWIDTH = 15.19
            Case "09", "10", "11", "12": dimensWIDTH = 16.69
            Case Else:  dimensWIDTH = 0
          End Select
        Case "E", "F":
          Select Case Right(srchCOLL, 2)
            Case "02", "03", "04": dimensWIDTH = 15.19
            Case Else:  dimensWIDTH = 0
          End Select
      End Select
  End Select
  Select Case srchFRAME
    Case "14": dimensHEIGHT = 16.25: dimensDEPTH = 15.125
    Case "16": dimensHEIGHT = 18.25: dimensDEPTH = 17.2
    Case "19": dimensHEIGHT = 20.5: dimensDEPTH = 19.5
  End Select

Case "HM":  'estimated per SS
  Select Case srchFRAME
    Case "14": dimensWIDTH = 7: dimensHEIGHT = 16.25: dimensDEPTH = 15.125
    Case "16": dimensWIDTH = 9: dimensHEIGHT = 18.25: dimensDEPTH = 17.2
    Case "19": dimensWIDTH = 9.5: dimensHEIGHT = 20.5: dimensDEPTH = 19.5
  End Select
Case "SHO", "TMR"
  Select Case LTrim$(RTrim$(collectorCODE))
    Case "23", "33", "43": dimensA = 10.69
    Case "63", "83", "27", "37", "47", "212", "220", "320", "420": dimensA = 13.19
    Case "67", "103", "123", "312": dimensA = 15.69
    Case "87", "143", "163", "412": dimensA = 18.19
    Case "203", "243": dimensA = 23.19
    Case "303", "363": dimensA = 30.19
  End Select

  Select Case srchSTYLE
    Case "SHO"
      Select Case srchSPRING
        Case "801":  dimensB = 1.19
        Case "802":  dimensB = 3.56
        Case "803":  dimensB = 5.94
        Case "804":  dimensB = 8.31
        Case "1001":  dimensB = 2.19
        Case "1002":  dimensB = 5.56
        Case "1003":  dimensB = 8.94
        Case "1004":  dimensB = 12.31
        Case "1005":  dimensB = 8.94
        Case "1006":  dimensB = 8.94
        Case "1007":  dimensB = 12.31
        Case "1008":  dimensB = 12.31
      End Select
    Case "TMR"
      Select Case srchMOTOR
        Case "2": dimensB = 26.69
        Case "3": dimensB = 39.12
        Case "5": dimensB = 35.25
        Case "7": dimensB = 37.25
        Case "9": dimensB = 39.88
        Case "14": dimensB = 42.5
      End Select
  End Select

  If dimensA > dimensB Then
    dimensZ = dimensA
  Else
    dimensZ = dimensB
  End If

  Select Case srchSPOOLMETHOD
    Case "M": dimensWIDTH = wrapperWIDTHr + 1! + 2.38 + 12 + dimensZ   'jpm
    Case "R": dimensWIDTH = srchSPOOLWIDTH + 0.96 + 2.38 + 12 + dimensZ
  End Select

  dimensHEIGHT = Val(srchFRAME)
  If srchSTYLE = "TMR" Or Val(srchSPRING) < 1005 Then
    dimensDEPTH = (Val(srchFRAME) / 2) + 24
  Else
    dimensDEPTH = 48
  End If
  If dimensDEPTH < dimensHEIGHT Then dimensDEPTH = dimensHEIGHT

Case "P":
  Select Case Trim(collectorCODE)
    Case "23", "33", "43": dimensA = 15!
    Case "63", "83": dimensA = 17.5
    Case "67", "103", "123", "312": dimensA = 20!
    Case "87", "143", "163", "412": dimensA = 22.5
    Case "203", "243": dimensA = 27.5
    Case "303", "363": dimensA = 35.5
  End Select

  If srchFRAME = "14" Then dimensA = dimensA - 0.5
  If srchFRAME = "28" Or srchFRAME = "32" Then dimensA = dimensA + 1!

  Select Case srchMOTOR
    Case "25":  dimensC = 9.25: dimensD = 17.5
    Case "50":  dimensC = 9.38: dimensD = 17!
    Case "75":  dimensC = 9.81: dimensD = 20!
    Case "150":  dimensC = 9.75: dimensD = 24!
  End Select

  Select Case srchFRAME
    Case "14": dimensHEIGHT = 16.5: dimensDEPTH = (14 / 2) + dimensD: dimensB = 4.12
    Case "16": dimensHEIGHT = 18.5: dimensDEPTH = (16 / 2) + dimensD: dimensB = 4.62
    Case "18": dimensHEIGHT = 20!: dimensDEPTH = (18 / 2) + dimensD: dimensB = 4.62
    Case "21": dimensHEIGHT = 23!: dimensDEPTH = (21 / 2) + dimensD: dimensB = 4.62
    Case "24": dimensHEIGHT = 26!: dimensDEPTH = (24 / 2) + dimensD: dimensB = 4.62
    Case "28": dimensHEIGHT = 30!: dimensDEPTH = (28 / 2) + dimensD: dimensB = 5.62
    Case "32": dimensHEIGHT = 34!: dimensDEPTH = (32 / 2) + dimensD: dimensB = 5.62
  End Select
 dimensWIDTH = dimensA + dimensB + dimensC
'need to find out how to sum for width, height and depth for each series  'jpm

End Select

End Sub


Function AWGorMCM$(Gauge$)

Select Case Gauge$
   Case "250"
       AWGorMCM$ = "MCM"
   Case "350"
       AWGorMCM$ = "MCM"
   Case "500"
       AWGorMCM$ = "MCM"
   Case Else
       AWGorMCM$ = "AWG"
End Select

End Function
Public Sub assignVOLTAGE(inputSTR$, outputSTR$)

Select Case LTrim$(RTrim$(inputSTR$))
  Case "5000": outputSTR$ = "5KV"
  Case "8000": outputSTR$ = "8KV"
  Case "15000": outputSTR$ = "15KV"
End Select

End Sub

Public Sub calcSTRETCHappl()
Dim ADJpretensionTURNS As Single
Dim spooledcableINERTIAinsideRADIUS As Single
Dim TEMPcircumferenceTOTAL As Single

Dim circumferenceATcenterOFmaxFULLlayerSTRE As Single
Dim maxWRAPSfromTORQUEstretch As Single

Dim maxFULLlayersatSTRETCHcapacity As Single
Dim extraWRAPSatSTRETCHcapacity As Single
Dim spooledcableINERTIAoutsideRADIUSstretch As Single
Dim spooledcableINERTIAstretch As Single
Dim totalSTRETCHinertia As Single
Dim spoolFULLmomentARMstretch As Single
Dim rpmSPOOLfullSTRETCH As Single
Dim torqueTOaccelerateREELstretch As Single
Dim torqueFROMpretensionTURNSstretch As Single

Dim FACMI As Single
Dim TTEL As Single
Dim TTES As Single

'write #1, ""
'write #1, "Begin STRETCH CALCS:"

If UCase(percentSAGstr) <> "STD" Or percentSAGstr <> Null Then
  percentSAG = Val(percentSAGstr) / 100
Else
  Select Case srchSTYLE
    Case "U": percentSAG = 10 / 100
    Case Else: percentSAG = 6 / 100
  End Select
End If

SAGfactor = 1 / (percentSAG * 8)

Select Case srchSTYLE:
  Case "S", "SM", "MMD", "SHO", "U":
    torqueACTIVEstretchLENGTH = (adjustedTORQUE - torqueTOovercomeCOLLECTORfriction - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM))) / (SAGfactor * cableWGT(1) * firstLAYERmomentARM * (1! + ((1! / SAGfactor) * accelINftsecsec / 32.2516)))
  Case "K":
   torqueACTIVEstretchLENGTH = (adjustedTORQUE - torqueTOovercomeCOLLECTORfriction - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM))) / (SAGfactor * hoseWGTboth * firstLAYERmomentARM * (1! + ((1! / SAGfactor) * accelINftsecsec / 32.2516)))
  Case "TMR"
   FACMI = (RMOTI * gearRATIO ^ 2 * accelINftsecsec) / (32.2516 * firstLAYERmomentARM)
   RNME = (speedINftsec * gearRATIO) / (2! * pi * firstLAYERmomentARM)
   If RNME > 450 And specificINPUT(modelINDEX) = False Then
     Call invalidSTORE(3)
     Exit Sub
   End If
   If RNME > 450 Then invalidWARNING = True
   If RNME > 600 Then
     TQOUTE = 0
   Else
    TQOUTE = Sqr(TQSIZ ^ 2! * (1! - (RNME ^ 2! / 600! ^ 2)))
   End If
   adjustedTORQUE = gearRATIO * TQOUTE
   TTES = adjustedTORQUE - torqueTOovercomeCOLLECTORfriction
   torqueACTIVEstretchLENGTH = (TTES - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM)) - FACMI) / (SAGfactor * cableWGT(1) * firstLAYERmomentARM * (1! + ((1! / SAGfactor) * accelINftsecsec / 32.2516)))

End Select
'write #1, "torqueACTIVEstretchLENGTH: " & Str(torqueACTIVEstretchLENGTH)
If torqueACTIVEstretchLENGTH < travelINft Then
  Select Case specificINPUT(modelINDEX)
    Case False:
      Call invalidSTORE(3)
      Exit Sub
    Case True
      invalidWARNING = True
  End Select
End If

maxFULLLAYERSfromTORQUEstretchR = 1!
extraWRAPSafterFULLLAYERStorqueSTRETCHr = 1!
TEMPcircumferenceTOTAL = deadWRAPlength
LINE460:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = extraWRAPSafterFULLLAYERStorqueSTRETCHr + 1!
If extraWRAPSafterFULLLAYERStorqueSTRETCHr > maxWRAPSperLAYERr Then GoTo LINE462
circumferenceATcenterOFmaxFULLlayerSTRE = (drumSIZE + (2! * maxFULLLAYERSfromTORQUEstretchR - 1!) * cableTHICK(1)) * pi / 12!
TEMPcircumferenceTOTAL = TEMPcircumferenceTOTAL + circumferenceATcenterOFmaxFULLlayerSTRE
If TEMPcircumferenceTOTAL <= torqueACTIVEstretchLENGTH + deadWRAPlength Then GoTo LINE460
GoTo LINE465
LINE462:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = 0!
maxFULLLAYERSfromTORQUEstretchR = maxFULLLAYERSfromTORQUEstretchR + 1!
GoTo LINE460
LINE465:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = extraWRAPSafterFULLLAYERStorqueSTRETCHr - 1!
maxFULLLAYERSfromTORQUEstretchR = maxFULLLAYERSfromTORQUEstretchR - 1!
maxWRAPSfromTORQUEstretch = (maxWRAPSperLAYERr * maxFULLLAYERSfromTORQUEstretchR + extraWRAPSafterFULLLAYERStorqueSTRETCHr)
maxLENGTHcableFROMtorqueSTRETCH = ((drumSIZE + maxFULLLAYERSfromTORQUEstretchR * cableTHICK(1)) * pi / 12! * maxWRAPSperLAYERr * maxFULLLAYERSfromTORQUEstretchR) + ((drumSIZE + ((2! * maxFULLLAYERSfromTORQUEstretchR + 1!) * cableTHICK(1))) * pi / 12! * extraWRAPSafterFULLLAYERStorqueSTRETCHr)
maxACTIVElengthOFcableFROMtorqueSTRETCH = maxLENGTHcableFROMtorqueSTRETCH - deadWRAPlength
'write #1, "maxACTIVElengthOFcableFROMtorqueSTRETCH: " & Str(maxACTIVElengthOFcableFROMtorqueSTRETCH)
If maxACTIVElengthOFcableFROMtorqueSTRETCH < travelINft Then
  Select Case specificINPUT(modelINDEX)
    Case False:
      Call invalidSTORE(3)
      Exit Sub
    Case True
      invalidWARNING = True
   End Select
End If

Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U":
    unusedSPRINGturnsFORstretch = 0!
    availableSPRINGturnsFORstretch = 0!
    If maxUSABLEwrapsR < springTURNSavailAFTERpretensionR Then GoTo LINE470
    maxSTRETCHcapacityOFreel = turnsACTIVEcableLENGTH
    unusedSPRINGturnsFORstretch = 0!
    maxFULLlayersatSTRETCHcapacity = maxFULLLAYERSfromTURNSr
    extraWRAPSatSTRETCHcapacity = extraWRAPSafterFULLLAYERSturnsr
    If maxWRAPSfromTORQUEstretch >= springTURNSavailAFTERpretensionR Then GoTo LINE468
    maxSTRETCHcapacityOFreel = maxACTIVElengthOFcableFROMtorqueSTRETCH
    unusedSPRINGturnsFORstretch = (springTURNSavailAFTERpretensionR - maxWRAPSfromTORQUEstretch) / gearRATIO
    maxFULLlayersatSTRETCHcapacity = maxFULLLAYERSfromTORQUEstretchR
    extraWRAPSatSTRETCHcapacity = extraWRAPSafterFULLLAYERStorqueSTRETCHr
LINE468:
    If extraWRAPSatSTRETCHcapacity <> 0! Then maxFULLlayersatSTRETCHcapacity = maxFULLlayersatSTRETCHcapacity + 1!
    GoTo LINE472
LINE470:
    maxSTRETCHcapacityOFreel = compartmentACTIVEcableLENGTH
    unusedSPRINGturnsFORstretch = 0!
    availableSPRINGturnsFORstretch = 0!
    maxFULLlayersatSTRETCHcapacity = maxUSABLElayersR
    extraWRAPSatSTRETCHcapacity = 0!
    If maxWRAPSfromTORQUEstretch >= maxUSABLEwrapsR Then GoTo LINE471
    maxSTRETCHcapacityOFreel = maxACTIVElengthOFcableFROMtorqueSTRETCH
    availableSPRINGturnsFORstretch = (springTURNSavailAFTERpretensionR - maxUSABLEwrapsR) / gearRATIO
    maxFULLlayersatSTRETCHcapacity = maxFULLLAYERSfromTORQUEstretchR
    extraWRAPSatSTRETCHcapacity = extraWRAPSafterFULLLAYERStorqueSTRETCHr
LINE471:
   If extraWRAPSatSTRETCHcapacity <> 0! Then maxFULLlayersatSTRETCHcapacity = maxFULLlayersatSTRETCHcapacity + 1!
LINE472:
   spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
   spooledcableINERTIAoutsideRADIUSstretch = (drumSIZE + 2! * maxFULLlayersatSTRETCHcapacity * cableTHICK(1)) / 24!
   If srchSTYLE = "K" Then
     spooledcableINERTIAstretch = (hoseWGTboth * maxSTRETCHcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSstretch ^ 2!)
   Else
     spooledcableINERTIAstretch = (cableWGT(1) * maxSTRETCHcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSstretch ^ 2!)
   End If
   totalSTRETCHinertia = reelINERTIA + spooledcableINERTIAstretch
   spoolFULLmomentARMstretch = (drumSIZE + (2! * maxFULLlayersatSTRETCHcapacity - 1!) * cableTHICK(1)) / 24!
   rpmSPOOLfullSTRETCH = speedINftsec / (2! * pi * spoolFULLmomentARMstretch * gearRATIO)
   torqueTOaccelerateREELstretch = (totalSTRETCHinertia * gearRATIO ^ 2! * rpmSPOOLfullSTRETCH) / (5.133 * speedINftsec / accelINftsecsec)
   ADJpretensionTURNS = pretensionTURNS * gearRATIO
   torqueFROMpretensionTURNSstretch = ADJslopeFIRSTpartOFcurve * ADJpretensionTURNS + ADJyinterceptFIRSTpartOFcurve
   If ADJpretensionTURNS <= ADJmaxTURNSforFIRSTpartOFcurve Then GoTo LINE474
   torqueFROMpretensionTURNSstretch = ADJslopeSECONDpartOFcurve * ADJpretensionTURNS + ADJyinterceptSECONDpartOFcurve
   If ADJpretensionTURNS <= ADJmaxTURNSforSECONDpartOFcurve Then GoTo LINE474
   torqueFROMpretensionTURNSstretch = ADJslopeTHIRDpartOFcurve * ADJpretensionTURNS + ADJyinterceptTHIRDpartOFcurve
LINE474:
   netTORQUEwithREELfullSTRETCH = (torqueFROMpretensionTURNSstretch - torqueTOaccelerateREELstretch - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
   'write #1, "netTORQUEwithREELfullSTRETCH: " & Str(netTORQUEwithREELfullSTRETCH)
   'write #1, "availableSPRINGturnsFORstretch: " & Str(availableSPRINGturnsFORstretch)
   'write #1, "unusedSPRINGturnsFORstretch: " & Str(unusedSPRINGturnsFORstretch)
   If specificINPUT(modelINDEX) = False Then
     If netTORQUEwithREELfullSTRETCH < 0 Then
       Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(3)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
     End If
     If availableSPRINGturnsFORstretch <> 0 Or unusedSPRINGturnsFORstretch <> 0 Then
       Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(4)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
       Exit Sub
     End If
   End If

  Case "TMR"
    maxSTRETCHcapacityOFreel = compartmentACTIVEcableLENGTH
   If maxWRAPSfromTORQUEstretch < maxUSABLEwrapsR Then maxSTRETCHcapacityOFreel = maxACTIVElengthOFcableFROMtorqueSTRETCH
  'write #1, "maxSTRETCHcapacityOFreel: " & Str(maxSTRETCHcapacityOFreel)
End Select
validTORQUE = True

End Sub





'MARKER1'
Public Sub calcLIFTappl()
Dim torqueMAXIMUMliftLENGTH As Single
Dim TEMPcircumferenceTOTAL As Single
Dim circumferenceATcenterOFmaxFULLlayerLIFT As Single
Dim maxWRAPSfromTORQUElift As Single
Dim pendantTORQUEftlb As Single
Dim liftTORQUEftlb As Single



Dim maxFULLlayersatLIFTcapacity As Single
Dim extraWRAPSatLIFTcapacity As Single
Dim spooledcableINERTIAinsideRADIUS As Single
Dim spooledcableINERTIAoutsideRADIUSlift As Single
Dim spooledcableINERTIAlift As Single
Dim spoolFULLmomentARMlift As Single
Dim torqueTOliftPENDANT As Single
Dim pendantINERTIAlift As Single
Dim totalLIFTinertia As Single
Dim rpmSPOOLfullLIFT As Single
Dim torqueTOaccelerateREELlift As Single
Dim ADJpretensionTURNS As Single
Dim torqueFROMpretensionTURNSlift As Single


Dim FACMI As Single
Dim TTEL As Single

'Write #1, ""
'Write #1, "Begin LIFT CALCS:"

pendantTORQUEftlb = pendantINlbs * firstLAYERmomentARM * (1! + (accelINftsecsec / 32.2516))

Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U":
    liftTORQUEftlb = (adjustedTORQUE - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
    torqueACTIVEliftLENGTH = (liftTORQUEftlb - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM)) - pendantTORQUEftlb) / (cableWGT(1) * firstLAYERmomentARM * (1! + (accelINftsecsec / 32.2516)))
    'write #1, "torqueACTIVEliftLENGTH: " & Str(torqueACTIVEliftLENGTH)
  Case "P":
    torqueACTIVEliftLENGTH = (torqueFROMmotor - (pendantINlbs * firstLAYERmomentARM)) / (cableWGT(1) * firstLAYERmomentARM)
  Case "K":
    'Write #1, "hoseWGTboth:" & Str(hoseWGTboth)
    liftTORQUEftlb = (adjustedTORQUE - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
    'Write #1, "adjustedTORQUE:" & Str(adjustedTORQUE)
    'Write #1, "torqueTOovercomeCOLLECTORfriction:" & Str(torqueTOovercomeCOLLECTORfriction)
    'Write #1, "torqueSAFETYfactor:" & Str(torqueSAFETYfactor)
    torqueACTIVEliftLENGTH = (liftTORQUEftlb - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM))) / (hoseWGTboth * firstLAYERmomentARM * (1! + (accelINftsecsec / 32.2516)))
    'Write #1, "liftTORQUEftlb:" & Str(liftTORQUEftlb)
    'Write #1, "torqueACTIVEliftLENGTH:" & Str(torqueACTIVEliftLENGTH)
  Case "TMR":
     FACMI = (RMOTI * gearRATIO ^ 2 * accelINftsecsec) / (32.2516 * firstLAYERmomentARM)
     RNME = (speedINftsec * gearRATIO) / (2! * pi * firstLAYERmomentARM)
     If RNME > 450 Then
      Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(3)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
     End If
     If RNME > 600 Then
       TQOUTE = 0
     Else
       TQOUTE = Sqr(TQSIZ ^ 2! * (1! - (RNME ^ 2! / 600! ^ 2)))
     End If
     adjustedTORQUE = gearRATIO * TQOUTE
     TTEL = (adjustedTORQUE - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
     torqueACTIVEliftLENGTH = (TTEL - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM)) - pendantTORQUEftlb - FACMI) / (cableWGT(1) * firstLAYERmomentARM * (1! + (accelINftsecsec / 32.2516)))
     'write #1, "torqueACTIVEliftLENGTH: " & Str(torqueACTIVEliftLENGTH)
End Select
torqueMAXIMUMliftLENGTH = torqueACTIVEliftLENGTH + deadWRAPlength

If torqueACTIVEliftLENGTH < travelINft Then
  Select Case specificINPUT(modelINDEX)
    Case False
      Call invalidSTORE(3)
      Exit Sub
    Case True
      invalidWARNING = True
    End Select
End If
 'Write #1, "CLEARED LIFT CHECK #1"
 'Write #1, "-----------------------------"
'**************************************************************************
'* Calculate # full layers (rows) and extra wraps based on lifting torque
'**************************************************************************
maxFULLLAYERSfromTORQUEliftR = 1!
extraWRAPSafterFULLLAYERStorqueLIFTr = 1!
TEMPcircumferenceTOTAL = deadWRAPlength

LINE440:
extraWRAPSafterFULLLAYERStorqueLIFTr = extraWRAPSafterFULLLAYERStorqueLIFTr + 1!
If extraWRAPSafterFULLLAYERStorqueLIFTr > maxWRAPSperLAYERr Then GoTo LINE442
circumferenceATcenterOFmaxFULLlayerLIFT = (drumSIZE + (2! * maxFULLLAYERSfromTORQUEliftR - 1!) * cableTHICK(1)) * pi / 12!
TEMPcircumferenceTOTAL = TEMPcircumferenceTOTAL + circumferenceATcenterOFmaxFULLlayerLIFT
''msgbox TEMPcircumferenceTOTAL
''msgbox torqueMAXIMUMliftLENGTH
If TEMPcircumferenceTOTAL <= torqueMAXIMUMliftLENGTH Then GoTo LINE440
GoTo LINE445
LINE442:
extraWRAPSafterFULLLAYERStorqueLIFTr = 0!
maxFULLLAYERSfromTORQUEliftR = maxFULLLAYERSfromTORQUEliftR + 1!
GoTo LINE440
LINE445:
extraWRAPSafterFULLLAYERStorqueLIFTr = extraWRAPSafterFULLLAYERStorqueLIFTr - 1!
maxFULLLAYERSfromTORQUEliftR = maxFULLLAYERSfromTORQUEliftR - 1!

'**************************************************************************
'* Refigure max and active length from above calculations
'* seems like you lose alittle capacity in the process
'**************************************************************************
maxWRAPSfromTORQUElift = (maxWRAPSperLAYERr * maxFULLLAYERSfromTORQUEliftR + extraWRAPSafterFULLLAYERStorqueLIFTr)
'write #1, "maxWRAPSfromTORQUElift: " & Str(maxWRAPSfromTORQUElift)
'write #1, "maxFULLLAYERSfromTORQUEliftR: " & Str(maxFULLLAYERSfromTORQUEliftR)
'write #1, "maxWRAPSperLAYERr: " & Str(maxWRAPSperLAYERr)

''msgbox extraWRAPSafterFULLLAYERStorqueLIFTr
maxLENGTHcableFROMtorqueLIFT = ((drumSIZE + maxFULLLAYERSfromTORQUEliftR * cableTHICK(1)) * pi / 12! * maxWRAPSperLAYERr * maxFULLLAYERSfromTORQUEliftR) + ((drumSIZE + ((2! * maxFULLLAYERSfromTORQUEliftR + 1!) * cableTHICK(1))) * pi / 12! * _
extraWRAPSafterFULLLAYERStorqueLIFTr)
maxACTIVElengthOFcableFROMtorqueLIFT = maxLENGTHcableFROMtorqueLIFT - deadWRAPlength
'Write #1, "maxLENGTHcableFROMtorqueLIFT: " & Str(maxLENGTHcableFROMtorqueLIFT)
'Write #1, "maxACTIVElengthOFcableFROMtorqueLIFT: " & Str(maxACTIVElengthOFcableFROMtorqueLIFT)

If maxACTIVElengthOFcableFROMtorqueLIFT < travelINft Then
  Select Case specificINPUT(modelINDEX)
    Case False
     Call invalidSTORE(3)
     Exit Sub
    Case True
     invalidWARNING = True
  End Select
End If
'Write #1, "CLEARED LIFT CHECK #2"
'Write #1, "-----------------------------"
Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U", "K":

    unusedSPRINGturnsFORlift = 0!
    availableSPRINGturnsFORlift = 0!

    'compartment, torque or turns dictate reels capacity?
    If maxUSABLEwrapsR < springTURNSavailAFTERpretensionR Then GoTo LINE450

    maxLIFTcapacityOFreel = turnsACTIVEcableLENGTH
    unusedSPRINGturnsFORlift = 0
    maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTURNSr
    extraWRAPSatLIFTcapacity = extraWRAPSafterFULLLAYERSturnsr
    If maxWRAPSfromTORQUElift >= springTURNSavailAFTERpretensionR Then GoTo LINE448

    maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
    unusedSPRINGturnsFORlift = (springTURNSavailAFTERpretensionR - maxWRAPSfromTORQUElift) / gearRATIO

    maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTORQUEliftR
    extraWRAPSatLIFTcapacity = extraWRAPSafterFULLLAYERStorqueLIFTr
LINE448:
    If extraWRAPSatLIFTcapacity <> 0! Then maxFULLlayersatLIFTcapacity = maxFULLlayersatLIFTcapacity + 1!
    GoTo LINE452

LINE450:
    maxLIFTcapacityOFreel = compartmentACTIVEcableLENGTH
    unusedSPRINGturnsFORlift = 0!
    availableSPRINGturnsFORlift = 0!
    maxFULLlayersatLIFTcapacity = maxUSABLElayersR
    extraWRAPSatLIFTcapacity = 0!
    If maxWRAPSfromTORQUElift >= maxUSABLEwrapsR Then GoTo LINE451
    maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
    availableSPRINGturnsFORlift = (springTURNSavailAFTERpretensionR - maxUSABLEwrapsR) / gearRATIO
    maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTORQUEliftR
    extraWRAPSatLIFTcapacity = extraWRAPSafterFULLLAYERStorqueLIFTr
LINE451:
    If extraWRAPSatLIFTcapacity <> 0! Then maxFULLlayersatLIFTcapacity = maxFULLlayersatLIFTcapacity + 1!
LINE452:
    spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
    spooledcableINERTIAoutsideRADIUSlift = (drumSIZE + 2! * maxFULLlayersatLIFTcapacity * cableTHICK(1)) / 24!
    If srchSTYLE = "K" Then
      spooledcableINERTIAlift = (hoseWGTboth * maxLIFTcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSlift ^ 2!)
    Else
      spooledcableINERTIAlift = (cableWGT(1) * maxLIFTcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSlift ^ 2!)
    End If
    'Write #1, "spooledcableINERTIAlift: " & Str(spooledcableINERTIAlift)
    spoolFULLmomentARMlift = (drumSIZE + (2! * maxFULLlayersatLIFTcapacity - 1!) * cableTHICK(1)) / 24!
    'Write #1, "spoolFULLmomentARMlift: " & Str(spoolFULLmomentARMlift)
    torqueTOliftPENDANT = pendantINlbs * spoolFULLmomentARMlift * gearRATIO
    'Write #1, "torqueTOliftPENDANT: " & Str(torqueTOliftPENDANT)
    pendantINERTIAlift = pendantINlbs * spoolFULLmomentARMlift ^ 2!
   'write #1, "pendantINERTIAlift: " & Str(pendantINERTIAlift)
    totalLIFTinertia = reelINERTIA + spooledcableINERTIAlift + pendantINERTIAlift
   'write #1, "totalLIFTinertia: " & Str(totalLIFTinertia)
    rpmSPOOLfullLIFT = speedINftsec / (2! * pi * spoolFULLmomentARMlift * gearRATIO)
   'write #1, "rpmSPOOLfullLIFT: " & Str(rpmSPOOLfullLIFT)
    torqueTOaccelerateREELlift = (totalLIFTinertia * gearRATIO ^ 2! * rpmSPOOLfullLIFT) / (5.133 * speedINftsec / accelINftsecsec)
   'write #1, "torqueTOaccelerateREELlift: " & Str(torqueTOaccelerateREELlift)
    ADJpretensionTURNS = pretensionTURNS * gearRATIO
   'write #1, "ADJpretensionTURNS: " & Str(ADJpretensionTURNS)
    torqueFROMpretensionTURNSlift = ADJslopeFIRSTpartOFcurve * ADJpretensionTURNS + ADJyinterceptFIRSTpartOFcurve
   'write #1, "torqueFROMpretensionTURNSlift: " & Str(torqueFROMpretensionTURNSlift)
    If ADJpretensionTURNS <= ADJmaxTURNSforFIRSTpartOFcurve Then GoTo LINE454
    torqueFROMpretensionTURNSlift = ADJslopeSECONDpartOFcurve * ADJpretensionTURNS + ADJyinterceptSECONDpartOFcurve
    If ADJpretensionTURNS <= ADJmaxTURNSforSECONDpartOFcurve Then GoTo LINE454
    torqueFROMpretensionTURNSlift = ADJslopeTHIRDpartOFcurve * ADJpretensionTURNS + ADJyinterceptTHIRDpartOFcurve
LINE454:
    netTORQUEwithREELfullLIFT = (torqueFROMpretensionTURNSlift - torqueTOaccelerateREELlift - torqueTOliftPENDANT - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
   'write #1, "netTORQUEwithREELfullLIFT: " & Format(netTORQUEwithREELfullLIFT, "#.##")
   'write #1, "availableSPRINGturnsFORlift: " & Str(availableSPRINGturnsFORlift)
   'write #1, "unusedSPRINGturnsFORlift: " & Str(unusedSPRINGturnsFORlift)
    If netTORQUEwithREELfullLIFT < 0 Then
       Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(3)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
     End If
      If availableSPRINGturnsFORlift <> 0 Or unusedSPRINGturnsFORlift <> 0 Then
        Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(4)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
      End If
  Case "P":
    maxLIFTcapacityOFreel = compartmentACTIVEcableLENGTH
    maxFULLlayersatLIFTcapacity = maxUSABLElayersR
    extraWRAPSatLIFTcapacity = 0!
    If compartmentACTIVEcableLENGTH < maxACTIVElengthOFcableFROMtorqueLIFT Then GoTo line600
    maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
    maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTORQUEliftR
    extraWRAPSatLIFTcapacity = extraWRAPSafterFULLLAYERStorqueLIFTr
  Case "TMR":
    maxLIFTcapacityOFreel = compartmentACTIVEcableLENGTH
    If maxWRAPSfromTORQUElift < maxUSABLEwrapsR Then maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
End Select
line600:
validTORQUE = True
'Write #1, "CLEARED LIFT CHECK #3"
'Write #1, "-----------------------------"

End Sub



Public Sub calcRETRIEVEappl()
Dim FACMIE As Single
Dim TORKE As Single
Dim TTERE As Single

'new code added per Steve Loeck 10/02/00
Dim R2RE As Single
Dim WRCBER As Single
Dim WRTOTE As Single
Dim RF As Single
Dim FACMIF As Single

Dim TORKF As Single
Dim TTERF As Single
Dim R2RF As Single
Dim WRCBFR As Single
Dim WRTOTF As Single

Dim RETR As Single

Dim ADJpretensionTURNS As Single
Dim torqueTOliftCABLEretr As Single
Dim maxFULLlayersatRETRIEVEcapacity As Single
Dim extraWRAPSatRETRIEVEcapacity As Single
Dim spooledcableINERTIAoutsideRADIUSretriev As Single
Dim spooledcableINERTIAretrieve As Single
Dim totalRETRIEVEinertia As Single
Dim spoolFULLmomentARMretrieve As Single
Dim rpmSPOOLfullRETRIEVE As Single
Dim torqueTOaccelerateREELretrieve As Single
Dim torqueFROMpretensionTURNSretrieve As Single
Dim spooledcableINERTIAinsideRADIUS As Single

'write #1, ""
'write #1, "Begin RETRIEVE CALCS:"

Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U":

    'RETRIEVE..... (check for adequate torque when reel is "almost " full)"
    maximumRETRIEVEcapacityOFreel = compartmentACTIVEcableLENGTH
    maxFULLlayersatRETRIEVEcapacity = maxUSABLElayersR
    extraWRAPSatRETRIEVEcapacity = 0!
    If turnsACTIVEcableLENGTH >= maximumRETRIEVEcapacityOFreel Then GoTo LINE485
    maximumRETRIEVEcapacityOFreel = turnsACTIVEcableLENGTH
    maxFULLlayersatRETRIEVEcapacity = maxFULLLAYERSfromTURNSr
    extraWRAPSatRETRIEVEcapacity = extraWRAPSafterFULLLAYERSturnsr
LINE485:
    If extraWRAPSatRETRIEVEcapacity <> 0! Then maxFULLlayersatRETRIEVEcapacity = maxFULLlayersatRETRIEVEcapacity + 1!
    spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
    spooledcableINERTIAoutsideRADIUSretriev = (drumSIZE + 2! * maxFULLlayersatRETRIEVEcapacity * cableTHICK(1)) / 24!
    spooledcableINERTIAretrieve = (cableWGT(1) * maximumRETRIEVEcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSretriev ^ 2!)
    totalRETRIEVEinertia = reelINERTIA + spooledcableINERTIAretrieve
    spoolFULLmomentARMretrieve = (drumSIZE + (2! * maxFULLlayersatRETRIEVEcapacity - 1!) * cableTHICK(1)) / 24!
    rpmSPOOLfullRETRIEVE = speedINftsec / (2! * pi * spoolFULLmomentARMretrieve * gearRATIO)
    torqueTOaccelerateREELretrieve = (totalRETRIEVEinertia * gearRATIO ^ 2! * rpmSPOOLfullRETRIEVE) / (5.133 * speedINftsec / accelINftsecsec)
    ADJpretensionTURNS = pretensionTURNS * gearRATIO
    torqueFROMpretensionTURNSretrieve = ADJslopeFIRSTpartOFcurve * ADJpretensionTURNS + ADJyinterceptFIRSTpartOFcurve
    If ADJpretensionTURNS <= ADJmaxTURNSforFIRSTpartOFcurve Then GoTo LINE490
    torqueFROMpretensionTURNSretrieve = ADJslopeSECONDpartOFcurve * ADJpretensionTURNS + ADJyinterceptSECONDpartOFcurve
    If ADJpretensionTURNS <= ADJmaxTURNSforSECONDpartOFcurve Then GoTo LINE490
    torqueFROMpretensionTURNSretrieve = ADJslopeTHIRDpartOFcurve * ADJpretensionTURNS + ADJyinterceptTHIRDpartOFcurve
LINE490:
    'torqueTOliftCABLEretr = spoolFULLmomentARMretrieve * (cableWGT(1) * centerlineHEIGHT)
    'netTORQUEwithREELfullRETRIEVE = (torqueFROMpretensionTURNSretrieve - torqueTOaccelerateREELretrieve - torqueTOovercomeCOLLECTORfriction - torqueTOliftCABLEretr) / torqueSAFETYfactor
    netTORQUEwithREELfullRETRIEVE = (torqueFROMpretensionTURNSretrieve - torqueTOaccelerateREELretrieve - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor
    maxCENTERLINEheight = (netTORQUEwithREELfullRETRIEVE / spoolFULLmomentARMretrieve) / cableWGT(1)
    'write #1, "netTORQUEwithREELfullRETRIEVE: " & Str(netTORQUEwithREELfullRETRIEVE)
    'write #1, "maxCENTERLINEheight: " & Str(maxCENTERLINEheight)
    If maxCENTERLINEheight < centerlineINft Then
      Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(3)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
    End If
Case "TMR"
  maximumRETRIEVEcapacityOFreel = compartmentACTIVEcableLENGTH
  maxFULLlayersatRETRIEVEcapacity = maxUSABLElayersR
  spooledcableINERTIAinsideRADIUS = drumSIZE / 24!

  FACMIE = (RMOTI * gearRATIO ^ 2 * accelINftsecsec) / (32.2516 * firstLAYERmomentARM)
  RNME = (speedINftsec * gearRATIO) / (2! * pi * firstLAYERmomentARM)
  If RNME > 450 Then
    Select Case specificINPUT(modelINDEX)
      Case False
        Call invalidSTORE(3)
        Exit Sub
      Case True
        invalidWARNING = True
    End Select
  End If

  If RNME > 600 Then
    TQOUTE = 0
  Else
    TQOUTE = Sqr(TQSIZ ^ 2! * (1! - (RNME ^ 2! / 600! ^ 2)))
  End If
  TORKE = gearRATIO * TQOUTE
  TTERE = (TORKE - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor

  'new code added per Steve Loeck 10/02/00
  R2RE = (drumSIZE + 2 * cableTHICK(1)) / 24
  WRCBER = (cableWGT(1) * deadWRAPlength / 2) * (spooledcableINERTIAinsideRADIUS ^ 2 + R2RE ^ 2)
  WRTOTE = reelINERTIA + WRCBER
  RETE = (TTERE - (WRTOTE * accelINftsecsec / (32.2516 * firstLAYERmomentARM)) - FACMIE) / (cableWGT(1) * firstLAYERmomentARM)
  'old calc: RETE = (TTERE - (reelINERTIA * accelINftsecsec / (32.2516 * firstLAYERmomentARM)) - FACMIE) / (cableWGT(1) * firstLAYERmomentARM * (1! + (accelINftsecsec / 32.2516)))

'spool full
  RF = (drumSIZE + (2! * maxUSABLElayersR - 1!) * cableTHICK(1)) / 24!
  FACMIF = (RMOTI * gearRATIO ^ 2 * accelINftsecsec) / (32.2516 * RF)
  RNMF = (speedINftsec * gearRATIO) / (2! * pi * RF)
  If RNMF > 600 Then
    Select Case specificINPUT(modelINDEX)
      Case False
        Call invalidSTORE(3)
        Exit Sub
      Case True
        invalidWARNING = True
    End Select
  End If
  If RNMF > 600 Then
    TQOUTF = 0
  Else
    TQOUTF = Sqr(TQSIZ ^ 2! * (1! - (RNMF ^ 2! / 600! ^ 2)))
  End If
  TORKF = gearRATIO * TQOUTF
  TTERF = (TORKF - torqueTOovercomeCOLLECTORfriction) / torqueSAFETYfactor

  'new code added per Steve Loeck 10/02/00
  R2RF = (drumSIZE + 2 * maxFULLlayersatRETRIEVEcapacity * cableTHICK(1)) / 24
  WRCBFR = (cableWGT(1) * maximumRETRIEVEcapacityOFreel / 2) * (spooledcableINERTIAinsideRADIUS ^ 2 + R2RF ^ 2)
  WRTOTF = reelINERTIA + WRCBFR
  RETF = (TTERF - (WRTOTF * accelINftsecsec / (32.2516 * RF)) - FACMIF) / (cableWGT(1) * RF)

  'old calc: RETF = (TTERF - (reelINERTIA * accelINftsecsec / (32.2516 * RF)) - FACMIF) / (cableWGT(1) * RF * (1! + (accelINftsecsec / 32.2516)))
  RETR = RETF
  If RETE < RETF Then RETR = RETE
   'write #1, "RETF: " & Str(RETF)
    'write #1, "RETR: " & Str(RETR)
  If RETR < centerlineINft Then
    Select Case specificINPUT(modelINDEX)
      Case False
        Call invalidSTORE(3)
        Exit Sub
      Case True
        invalidWARNING = True
    End Select
  End If
  maxCENTERLINEheight = RETR


adjustedTORQUE = TORKE
If TORKF > TORKE Then adjustedTORQUE = TORKF


End Select

validTORQUE = True


End Sub


Public Sub getSPRINGdata()
'* This sub loads the torque curve data for the various springs.  The index corresponds to
'* the spring family as follows:
'* spring 35 -> index = 1
'* spring 60 ->index = 2
'* spring 62 ->index = 3
'* spring 75 ->index = 4
'* spring 80 ->index = 5
'* spring 100 ->index = 1


maxSPRINGturns(1) = 16
maxSPRINGturns(2) = 20
maxSPRINGturns(3) = 29
maxSPRINGturns(4) = 13
maxSPRINGturns(5) = 23
maxSPRINGturns(6) = 15

maxTURNSforFIRSTpartOFcurve(1) = 16
maxTURNSforFIRSTpartOFcurve(2) = 5
maxTURNSforFIRSTpartOFcurve(3) = 2
maxTURNSforFIRSTpartOFcurve(4) = 2
maxTURNSforFIRSTpartOFcurve(5) = 3
maxTURNSforFIRSTpartOFcurve(6) = 2

slopeFIRSTpartOFcurve(1) = 0.55
slopeFIRSTpartOFcurve(2) = 0.63
slopeFIRSTpartOFcurve(3) = 1.14
slopeFIRSTpartOFcurve(4) = 5.33
slopeFIRSTpartOFcurve(5) = 3
slopeFIRSTpartOFcurve(6) = 11.2

yinterceptFIRSTpartOFcurve(1) = 0
yinterceptFIRSTpartOFcurve(2) = 0
yinterceptFIRSTpartOFcurve(3) = 0
yinterceptFIRSTpartOFcurve(4) = 0
yinterceptFIRSTpartOFcurve(5) = 0
yinterceptFIRSTpartOFcurve(6) = 0

maxTURNSforSECONDpartOFcurve(1) = 0
maxTURNSforSECONDpartOFcurve(2) = 20
maxTURNSforSECONDpartOFcurve(3) = 17
maxTURNSforSECONDpartOFcurve(4) = 9
maxTURNSforSECONDpartOFcurve(5) = 9
maxTURNSforSECONDpartOFcurve(6) = 8

slopeSECONDpartOFcurve(1) = 0
slopeSECONDpartOFcurve(2) = 0.22
slopeSECONDpartOFcurve(3) = 0.47
slopeSECONDpartOFcurve(4) = 2
slopeSECONDpartOFcurve(5) = 0.57
slopeSECONDpartOFcurve(6) = 3.43

yinterceptSECONDpartOFcurve(1) = 0
yinterceptSECONDpartOFcurve(2) = 2
yinterceptSECONDpartOFcurve(3) = 1.8
yinterceptSECONDpartOFcurve(4) = 6.5
yinterceptSECONDpartOFcurve(5) = 7.5
yinterceptSECONDpartOFcurve(6) = 16

maxTURNSforTHIRDpartOFcurve(1) = 0
maxTURNSforTHIRDpartOFcurve(2) = 0
maxTURNSforTHIRDpartOFcurve(3) = 29
maxTURNSforTHIRDpartOFcurve(4) = 13
maxTURNSforTHIRDpartOFcurve(5) = 23
maxTURNSforTHIRDpartOFcurve(6) = 15

slopeTHIRDpartOFcurve(1) = 0
slopeTHIRDpartOFcurve(2) = 0
slopeTHIRDpartOFcurve(3) = 0.22
slopeTHIRDpartOFcurve(4) = 1
slopeTHIRDpartOFcurve(5) = 0.84
slopeTHIRDpartOFcurve(6) = 0.73

yinterceptTHIRDpartOFcurve(1) = 0
yinterceptTHIRDpartOFcurve(2) = 0
yinterceptTHIRDpartOFcurve(3) = 6
yinterceptTHIRDpartOFcurve(4) = 15.5
yinterceptTHIRDpartOFcurve(5) = 3.5
yinterceptTHIRDpartOFcurve(6) = 38

End Sub
Public Sub assignCCF()
If srchSTYLE = "K" Then
  cableCLEARANCEfactor = 0
Else
  Select Case maxCABLEwrapsI
    Case Is <= 16: cableCLEARANCEfactor = 0.6
    Case Is <= 24: cableCLEARANCEfactor = 0.8
    Case Is <= 32: cableCLEARANCEfactor = 1!
    Case Is <= 40: cableCLEARANCEfactor = 1.2
    Case Is <= 48: cableCLEARANCEfactor = 1.4
    Case Is <= 56: cableCLEARANCEfactor = 1.6
    Case Is <= 64: cableCLEARANCEfactor = 1.8
    Case Is <= 72: cableCLEARANCEfactor = 2!
    Case Is <= 80: cableCLEARANCEfactor = 2.2
    Case Else: cableCLEARANCEfactor = 2.4
  End Select
End If


End Sub
Public Sub doINITIALcalcs()
Dim fileSTR As String
Dim SPOOLWIDTH As Single

'fileSTR = searchRS!style & searchRS!FRAME & searchRS!SPRINGS & "-" & Str(pretensionTURNS)
'Write #2, fileSTR
fileSTR = ""
validCOMPARTMENT = False
validTURNS = False

Select Case srchSTYLE
  Case "S", "SM", "MMD", "P":
    Select Case frameSIZE
      Case 14: wrapperWIDTHi = 4
      Case 16: wrapperWIDTHi = 5
      Case 18: wrapperWIDTHi = 5
      Case 21: wrapperWIDTHi = 5
      Case 24: wrapperWIDTHi = 5
      Case 28: wrapperWIDTHi = 7
      Case 32: wrapperWIDTHi = 7
    End Select
    If srchSTYLE = "S" And frameSIZE > 15 And frameSIZE < 25 And SWopt Then wrapperWIDTHi = 7
    wrapperWIDTHr = wrapperWIDTHi
  Case "SHO", "TMR":
    If srchSPOOLMETHOD = "M" Then
      Select Case srchSPOOLWIDTH
        Case "MA": SPOOLWIDTH = 0.75
        Case "MB": SPOOLWIDTH = 1!
        Case "MC": SPOOLWIDTH = 1.25
        Case "MD": SPOOLWIDTH = 1.5
        Case "ME": SPOOLWIDTH = 1.75
        Case "MF": SPOOLWIDTH = 2!
        Case "MX": SPOOLWIDTH = 1.1 * cableTHICK(1)
      End Select
      wrapperWIDTHr = SPOOLWIDTH      'assigned during model number input
      wrapperWIDTHr = 1.1 * cableTHICK(1)
      spoolWIDTHcode = srchSPOOLWIDTH
    Else
      wrapperWIDTHr = Val(srchSPOOLWIDTH)
    End If
  Case "K":
    Select Case hoseIDcode
      Case "4": wrapperWIDTHr = 1.25: hoseWGTboth = 2 * (cableWGT(1) + 0.02)
      Case "6": wrapperWIDTHr = 1.75: hoseWGTboth = 2 * (cableWGT(1) + 0.05)
      Case "8": wrapperWIDTHr = 2.125: hoseWGTboth = 2 * (cableWGT(1) + 0.09)
      Case "12": wrapperWIDTHr = 2.75: hoseWGTboth = 2 * (cableWGT(1) + 0.19)
    End Select
    If UCase(Cable(1).itemTYPE) = "AIR" Then
      hoseWGTboth = 2 * cableWGT(1)
    End If
  Case "U":
   wrapperWIDTHr = UreelWIDTH
   reelWIDTHinp = UreelWIDTHinp
End Select

'If LTrim$(reelTYPEdisplayed) = "SW" Then wrapperWIDTHi = 7  'SS
If srchSTYLE = "K" Then
  maxWRAPSperLAYERr = 1
Else
  maxWRAPSperLAYERr = wrapperWIDTHr / cableTHICK(1)
End If
maxWRAPSperLAYERrSTORED = maxWRAPSperLAYERr
maxWRAPSperLAYERi = Int(maxWRAPSperLAYERr)
maxWRAPSperLAYERr = maxWRAPSperLAYERi
'Write #1, "maxWRAPSperLAYERr: " & Str(maxWRAPSperLAYERr)
maxCABLElayersR = (frameSIZE - drumSIZE) / (2! * cableTHICK(1))
'Write #1, "maxCABLElayersR: " & Str(maxCABLElayersR)
maxCABLElayersI = Int(maxCABLElayersR)
maxCABLEwrapsI = maxWRAPSperLAYERi * maxCABLElayersI
'Write #1, "maxCABLEwrapsI: " & Str(maxCABLEwrapsI)

If CableCF = 0 Then
  Call assignCCF
Else
  cableCLEARANCEfactor = CableCF
End If
'Write #1, "maxCABLElayersR: " & Str(maxCABLElayersR)
'Write #1, "cableCLEARANCEfactor: " & Str(cableCLEARANCEfactor)
maxUSABLElayersR = maxCABLElayersR - cableCLEARANCEfactor
'Write #1, "maxUSABLElayersR: " & Str(maxUSABLElayersR)
maxUSABLElayersI = Int(maxUSABLElayersR)
maxUSABLElayersR = maxUSABLElayersI

maxUSABLEwrapsR = maxWRAPSperLAYERr * maxUSABLElayersR
'Write #1, "maxUSABLEwrapsR: " & Str(maxUSABLEwrapsR)
'**********************************************************
'* Calculates cable that can be physically place in compartment
'**********************************************************
compartmentHEIGHT = (frameSIZE - drumSIZE) / 2!
'Write #1, "compartmentHEIGHT: " & Str(compartmentHEIGHT)
Select Case searchRS!style
   Case "S", "SM", "MMD", "U":  fileSTR = searchRS!style & searchRS!FRAME & searchRS!SPRINGS & "-" & searchRS!gear
   Case "SHO": fileSTR = searchRS!style & "-" & searchRS!stype & searchRS!SPRINGS & "-" & searchRS!swidth & "-" & Trim(searchRS!sdiam) & "-" & searchRS!gear
   Case "TMR": fileSTR = searchRS!style & "-" & searchRS!stype & searchRS!MOTOR & "-" & searchRS!swidth & "-" & Trim(searchRS!sdiam) & "-" & searchRS!gear
   Case "P": fileSTR = searchRS!style & searchRS!FRAME & "-" & searchRS!MOTOR
   Case "K":  fileSTR = searchRS!style & searchRS!FRAME & searchRS!SPRINGS
 End Select
'fileSTR = fileSTR & "  Frame SIZE: " & Str(frameSIZE)
'fileSTR = fileSTR & "  Drum SIZE: " & Str(drumSIZE)
fileSTR = fileSTR & "-" & Str(pretensionTURNS)
'Write #1, ""
'Write #1, ""
'Write #1, fileSTR
fileSTR = ""
fileSTR = "Compart hght: " & Str(compartmentHEIGHT)
fileSTR = fileSTR & "  maxUSABLElayersR: " & Str(maxUSABLElayersR)
fileSTR = fileSTR & "  maxWRAPSperLAYERr: " & Str(maxWRAPSperLAYERr)
'write #1, fileSTR

deadWRAPlength = deadWRAPS * (drumSIZE + cableTHICK(1)) * pi / 12!
'Write #1, "deadWRAPlength: " & Str(deadWRAPlength)

cableLAYERindexR = 0                             'INDEX FOR WRAPS VERTICALLY
compartmentCABLEcapacity = 0

Do
  cableLAYERindexR = cableLAYERindexR + 1!
  If cableLAYERindexR > maxUSABLElayersR Then Exit Do
  Select Case searchRS!style
    Case "SHO", "TMR":  'added 7/07 if SHO/TMR per SS.  Instead of calc' compartment as 4 stack of 4 (example), we are changing to 4,3,4,3
      Select Case srchSPOOLMETHOD
        Case "R": 'it's random wrap so remove 1 layer every other time to account for uneven wrapping
          If cableLAYERindexR / 2 = Int(cableLAYERindexR / 2) Then 'it's an even # layer so take out 1 wrap
             layerCABLEcapacity = (maxWRAPSperLAYERr - 1) * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
          Else  ' it's an odd number layer so use full number of wraps
             layerCABLEcapacity = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
          End If
        Case Else 'it's monospiral so use full number on each wrap
          layerCABLEcapacity = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
      End Select
    Case "U":  'changed 4/10 per SS due to wrapping overloads experienced in field.  Now we follow same protocol as SHO above
      If cableLAYERindexR / 2 = Int(cableLAYERindexR / 2) Then 'it's an even # layer so take out 1 wrap
        layerCABLEcapacity = (maxWRAPSperLAYERr - 1) * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
      Else  ' it's an odd number layer so use full number of wraps
        layerCABLEcapacity = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
      End If
    Case Else:
      layerCABLEcapacity = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
  End Select
  'debug MsgBox "layer # " & cableLAYERindexR & " :" & layerCABLEcapacity
  'debug MsgBox "one wrap: " & (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
  compartmentCABLEcapacity = compartmentCABLEcapacity + layerCABLEcapacity
  'debug MsgBox "total so far: " & compartmentCABLEcapacity
Loop
compartmentACTIVEcableLENGTH = compartmentCABLEcapacity - deadWRAPlength
'write #1, "Active cable length for compartment: " & Str(compartmentACTIVEcableLENGTH)

If compartmentACTIVEcableLENGTH < travelINft Then
  Select Case specificINPUT(modelINDEX)
    Case False
     Call invalidSTORE(1)
     Exit Sub
    Case True
     invalidWARNING = True
  End Select
End If
validCOMPARTMENT = True
'write #1, "-----------------------------------------"

Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U", "K":
    Call calcTORQUE
    'write #1, "Active cable length for turns: " & Str(turnsACTIVEcableLENGTH)
    If turnsACTIVEcableLENGTH < travelINft Then
      Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(2)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
    End If
    'write #1, "cleared check2"
  Case "TMR"
    Select Case srchMOTOR
      Case "2": TQSIZ = 2.4: RMOTI = 0.093
      Case "3": TQSIZ = 3.7: RMOTI = 0.164
      Case "5": TQSIZ = 5.1: RMOTI = 0.29
      Case "7": TQSIZ = 7.8: RMOTI = 0.486
      Case "9": TQSIZ = 9.8: RMOTI = 0.923
      Case "14": TQSIZ = 14!: RMOTI = 1.478
    End Select
    'write #1, "check2 skipped"
  Case "P"
    Select Case srchMOTOR
      Case "25": torqueFROMmotor = 21.9     'torq = (HP * 5250)/RPM * GR * EFF
      Case "50": torqueFROMmotor = 43.8     ' where RPM = 1800, GR = 60, EFF = .5
      Case "75": torqueFROMmotor = 65.7
      Case "150": torqueFROMmotor = 131.4
    End Select
 End Select


 'write #1, "-----------------------------------------"


cableCLEARANCEinINCHESless1layer = 0
cableCLEARANCEinINCHESless2layers = 0
cableCLEARANCEinINCHESless3layers = 0
cableCAPACITYlostFIRSTclearanceWRAP = 0!
cableCAPACITYlostSECONDclearanceWRAP = 0!
cableCAPACITYlostTHIRDclearanceWRAP = 0!
cableCLEARANCEinINCHES = ((frameSIZE - drumSIZE) / 2!) - (maxUSABLElayersR * cableTHICK(1))

cableLAYERindexI = Int(cableLAYERindexR)

If cableLAYERindexI > maxCABLElayersI Then GoTo LINE417
cableCAPACITYlostFIRSTclearanceWRAP = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
cableCLEARANCEinINCHESless1layer = ((frameSIZE - drumSIZE) / 2!) - ((maxUSABLElayersR + 1) * cableTHICK(1))
cableLAYERindexR = cableLAYERindexR + 1!
cableLAYERindexI = Int(cableLAYERindexR)


If cableLAYERindexI > maxCABLElayersI Then GoTo LINE417
cableCAPACITYlostSECONDclearanceWRAP = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
cableCLEARANCEinINCHESless2layers = ((frameSIZE - drumSIZE) / 2!) - ((maxUSABLElayersR + 2) * cableTHICK(1))

cableLAYERindexR = cableLAYERindexR + 1!
cableLAYERindexI = Int(cableLAYERindexR)


If cableLAYERindexI > maxCABLElayersI Then GoTo LINE417
cableCAPACITYlostTHIRDclearanceWRAP = maxWRAPSperLAYERr * (drumSIZE + (2! * cableLAYERindexR - 1!) * cableTHICK(1)) * pi / 12!
cableCLEARANCEinINCHESless3layers = ((frameSIZE - drumSIZE) / 2!) - ((maxUSABLElayersR + 3) * cableTHICK(1))

LINE417:
compartmentMAXIMUMcableLENGTH = compartmentCABLEcapacity + cableCAPACITYlostFIRSTclearanceWRAP + cableCAPACITYlostSECONDclearanceWRAP + cableCAPACITYlostTHIRDclearanceWRAP
'write #1, "compartmentMAXIMUMcableLENGTH: " & Str(compartmentMAXIMUMcableLENGTH)

'**********************************************************
'The following code calculates the collector friction (ft/lbs)
'**********************************************************
If srchSTYLE <> "P" Then
Select Case cableORhose
  Case "HD", "HS":  'hoses
    Select Case srchSTYLE
      Case "K":
        torqueTOovercomeCOLLECTORfriction = 1
      Case "U", "HM":
        'although it says  "collector" friciton, it's actually swivel friction
        Select Case hoseIDcode  'from super-swivel chart of rotating torque vs. pressure
          Case "4": torqueTOovercomeCOLLECTORfriction = 2.5 / 12  'inch pounds/12" to get foot pounds
          Case "6": torqueTOovercomeCOLLECTORfriction = 5 / 12
          Case "8": torqueTOovercomeCOLLECTORfriction = 7.5 / 12
          Case "12": torqueTOovercomeCOLLECTORfriction = 12.5 / 12
          Case "16": torqueTOovercomeCOLLECTORfriction = 20 / 12
          Case "20": torqueTOovercomeCOLLECTORfriction = 50 / 12
          Case "24": torqueTOovercomeCOLLECTORfriction = 56 / 12
       End Select
    End Select
  Case Else
    Select Case collectorAMP  'COLLECTOR DRAG (takes into account ground check at 35 amps if it exists)
      Case 35: torqueTOovercomeCOLLECTORfriction = 0.5 + 0.2 * numCOLLECTORconductors + grndchkQTY
      Case 75: torqueTOovercomeCOLLECTORfriction = 0.5 + 0.4 * numCOLLECTORconductors + (grndchkQTY * 0.7) 'IF GROUND CHECK, ADDS ADDTL TORQUE (grnd chk 35 amps)
      Case 125:
        Select Case srchSTYLE
         Case "U": 'SS
           torqueTOovercomeCOLLECTORfriction = 0.5 + 1.2 * numCOLLECTORconductors + (grndchkQTY * 0.7) 'IF GROUND CHECK, ADDS ADDTL TORQUE (grnd chk 35 amps)  SS
         Case Else:
           torqueTOovercomeCOLLECTORfriction = 0.5 + 1.2 * numCOLLECTORconductors + (grndchkQTY * 0.7) 'IF GROUND CHECK, ADDS ADDTL TORQUE (grnd chk 35 amps)
        End Select
      Case 200: torqueTOovercomeCOLLECTORfriction = 0.5 + 1.2 * numCOLLECTORconductors + (grndchkQTY * 0.7) 'IF GROUND CHECK, ADDS ADDTL TORQUE (grnd chk 35 amps)
      'M. Marzion guessed at the 400 amp drag (2!)
      Case 400:  torqueTOovercomeCOLLECTORfriction = 0.5 + 2! * numCOLLECTORconductors + (grndchkQTY * 0.7) 'IF GROUND CHECK, ADDS ADDTL TORQUE (grnd chk 35 amps)
    End Select
 End Select
 Call calcINERTIA
 '****************************************************************************
' The following code assigns a torque safety factor based on cable diameter
'****************************************************************************
Select Case srchSTYLE
  Case "S", "SM", "MMD", "SHO", "U", "K":
    Select Case cableTHICK(1)
      Case Is <= 0.5: torqueSAFETYfactor = 1.2
      Case Is <= 0.75
        If drumSIZE <= 9! Then torqueSAFETYfactor = 1.3
        If drumSIZE > 9! Then torqueSAFETYfactor = 1.2
      Case Is <= 1!
        If drumSIZE <= 12! Then torqueSAFETYfactor = 1.4
        If drumSIZE > 12! Then torqueSAFETYfactor = 1.3
      Case Is <= 1.25
        If drumSIZE <= 15! Then torqueSAFETYfactor = 1.5
        If drumSIZE > 15! Then torqueSAFETYfactor = 1.4
      Case Is <= 1.5
        If drumSIZE <= 18! Then torqueSAFETYfactor = 1.6
        If drumSIZE > 18! Then torqueSAFETYfactor = 1.5
      Case Else
        If drumSIZE <= 21! Then torqueSAFETYfactor = 1.7
        If drumSIZE > 21! Then torqueSAFETYfactor = 1.6
   End Select
 Case "TMR": torqueSAFETYfactor = 1.25
End Select
End If

firstLAYERmomentARM = (drumSIZE + cableTHICK(1)) / (2! * 12!)





'*********************************************************************
' The following code does ????????????????????
'*********************************************************************
'adjustedTORQUE = springTORQUEavailFORreeling
'If compartmentACTIVEcableLENGTH < turnsACTIVEcableLENGTH Then
'  tempTURNS = (gearRATIO * pretensionTURNS) + maxUSABLEwrapsR - 1
'  adjustedTORQUE = ADJslopeFIRSTpartOFcurve * tempTURNS + ADJyinterceptFIRSTpartOFcurve
  'msgbox adjustedTORQUE
  'msgbox ADJmaxTURNSforFIRSTpartOFcurve
  'msgbox ADJmaxTURNSforSECONDpartOFcurve
  'msgbox ADJslopeFIRSTpartOFcurve
  'msgbox ADJyinterceptFIRSTpartOFcurve
  'msgbox ADJslopeSECONDpartOFcurve
  'msgbox ADJyinterceptSECONDpartOFcurve
  'msgbox ADJslopeTHIRDpartOFcurve
  'msgbox ADJyinterceptTHIRDpartOFcurve
'  If tempTURNS > ADJmaxTURNSforFIRSTpartOFcurve Then
'    adjustedTORQUE = ADJslopeSECONDpartOFcurve * tempTURNS + ADJyinterceptSECONDpartOFcurve
'    If tempTURNS > ADJmaxTURNSforSECONDpartOFcurve Then
'      adjustedTORQUE = ADJslopeTHIRDpartOFcurve * tempTURNS + ADJyinterceptTHIRDpartOFcurve
'    End If
'  End If
'End If
''Debug.Print "clear check3"
validTURNS = True

'write #1, "Initial calcs complete"
'write #1, "=================================="
End Sub
Public Sub assignGEARratio(gearINPUT$)

Select Case srchSTYLE
  Case "S", "SM", "MMD":
    Select Case Trim(gearINPUT$)
     Case "N/A": gearRATIOstr = "1.00": gearRATIO = 1!
     Case "A": gearRATIOstr = "1.22": gearRATIO = 1.22
     Case "B": gearRATIOstr = "1.50": gearRATIO = 1.5
     Case "C": gearRATIOstr = "1.86": gearRATIO = 1.86
     Case "D": gearRATIOstr = "2.07": gearRATIO = 2.07
     Case "E": gearRATIOstr = "2.33": gearRATIO = 2.33
     Case "F": gearRATIOstr = "3.00": gearRATIO = 3!
     Case "G": gearRATIOstr = "4.00": gearRATIO = 4!
     Case "J": gearRATIOstr = "2.00": gearRATIO = 2!
     Case "K": gearRATIOstr = "2.33": gearRATIO = 2.33
     Case "M": gearRATIOstr = "1.50": gearRATIO = 1.5
     Case "N": gearRATIOstr = "1.72": gearRATIO = 1.72
     Case "P": gearRATIOstr = "2.00": gearRATIO = 2!
     Case "Q": gearRATIOstr = "2.33": gearRATIO = 2.33
     Case "R": gearRATIOstr = "2.75": gearRATIO = 2.75
     Case "S": gearRATIOstr = "4.00": gearRATIO = 4!
     Case "T": gearRATIOstr = "1.50": gearRATIO = 1.5
     Case "V": gearRATIOstr = "2.00": gearRATIO = 2!
     Case "W": gearRATIOstr = "2.75": gearRATIO = 2.75
     Case "Y": gearRATIOstr = "4.00": gearRATIO = 4!
     Case "ALL": gearRATIOstr = "ALL "
     Case Else: gearRATIOstr = "1.00": gearRATIO = 1!
    End Select
  Case "U":
    Select Case Trim(gearINPUT$)
     Case "N/A": gearRATIOstr = "1.00": gearRATIO = 1!
     Case "A": gearRATIOstr = "1.50": gearRATIO = 1.5
     Case "B": gearRATIOstr = "2.00": gearRATIO = 2!
     Case "C": gearRATIOstr = "2.50": gearRATIO = 2.5
     Case "D": gearRATIOstr = "3.0": gearRATIO = 3!
     Case "E": gearRATIOstr = "3.33": gearRATIO = 3.33
     Case "F": gearRATIOstr = "4.00": gearRATIO = 4!
     Case "ALL": gearRATIOstr = "ALL "
     Case Else: gearRATIOstr = "1.00": gearRATIO = 1!
    End Select
  Case "SHO", "TMR":
    Select Case Right(gearINPUT$, 1)
     Case "A": gearRATIOstr = "3.00": gearRATIO = 3!
     Case "B": gearRATIOstr = "2.50": gearRATIO = 2.5
     Case "C": gearRATIOstr = "2.00": gearRATIO = 2!
     Case "D": gearRATIOstr = "1.50": gearRATIO = 1.5
     Case "E": gearRATIOstr = "1.00": gearRATIO = 1!
     Case "L": gearRATIOstr = "ALL "
     Case Else: gearRATIOstr = "1.00": gearRATIO = 1!
    End Select
  Case Else: gearRATIOstr = "1.00": gearRATIO = 1!
End Select

End Sub

Public Sub checkPRETENSturns()
If UCase(TURNSusedPERCENTstr) = "STD" Then
  Select Case srchSTYLE
    Case "S", "SHO", "U", "C", "K", "HM": TURNSusedPERCENT = 100
    Case "SM": TURNSusedPERCENT = 66
    Case "MMD": TURNSusedPERCENT = 80
  End Select
Else
  TURNSusedPERCENT = Val(TURNSusedPERCENTstr)
End If

Select Case srchSTYLE
  Case "C", "HM":
    Select Case srchSPRING
     Case "A", "1": validPRETENSmax = 16 * (TURNSusedPERCENT / 100)
     Case "B", "2": validPRETENSmax = 19 * (TURNSusedPERCENT / 100)
     Case "C", "3": validPRETENSmax = 24 * (TURNSusedPERCENT / 100)
     Case "D", "4": validPRETENSmax = 26 * (TURNSusedPERCENT / 100)
     Case "E", "5": validPRETENSmax = 16 * (TURNSusedPERCENT / 100)
     Case "F", "6": validPRETENSmax = 0 * (TURNSusedPERCENT / 100)
     Case "G", "7": validPRETENSmax = 25 * (TURNSusedPERCENT / 100)
     Case "H", "8": validPRETENSmax = 22 * (TURNSusedPERCENT / 100)
     Case "J", "10": validPRETENSmax = 33 * (TURNSusedPERCENT / 100)
     Case "K", "11": validPRETENSmax = 27 * (TURNSusedPERCENT / 100)
     Case "U": validPRETENSmax = 33 * (TURNSusedPERCENT / 100)
     Case "V": validPRETENSmax = 34 * (TURNSusedPERCENT / 100)
     Case Else: validPRETENSmax = 33 * (TURNSusedPERCENT / 100)
    End Select
    maxTURNSfromSPRING = validPRETENSmax
  Case Else
    Select Case Val(srchSPRING)
     Case Is >= 1001: validPRETENSmax = 15 * (TURNSusedPERCENT / 100)
     Case Is >= 801:  validPRETENSmax = 23 * (TURNSusedPERCENT / 100)
     Case Is >= 751:  validPRETENSmax = 13 * (TURNSusedPERCENT / 100)
     Case Is >= 621:  validPRETENSmax = 29 * (TURNSusedPERCENT / 100)
     Case Is >= 601:  validPRETENSmax = 20 * (TURNSusedPERCENT / 100)
     Case Is >= 351:  validPRETENSmax = 16 * (TURNSusedPERCENT / 100)
    End Select
End Select

'if 'write #1, "srchPREMAX: " & Str(srchPREMAX)
If Val(srchPREMAX) < validPRETENSmax Then validPRETENSmax = Val(srchPREMAX)


End Sub
Public Sub checkDRUMsize()

Select Case srchSTYLE
  Case "SHO", "TMR":
    validDRUMmax = Val(srchFRAME) - ((1 + cableCLEARANCEfactor) * 2 * cableTHICK(1))
    validDRUMmax = Int(validDRUMmax)
    If (validDRUMmax Mod 2) <> 0 Then validDRUMmax = validDRUMmax - 1
    Select Case srchFRAME
      Case "30": If validDRUMmax > 24 Then validDRUMmax = 24
      Case "36": If validDRUMmax > 30 Then validDRUMmax = 30
      Case "42": If validDRUMmax > 36 Then validDRUMmax = 36
      Case "48": If validDRUMmax > 42 Then validDRUMmax = 42
      Case Else: If validDRUMmax > 48 Then validDRUMmax = 48
    End Select
  Case "S", "SM", "MMD", "P":
    validDRUMmax = Val(srchFRAME) - ((1 + cableCLEARANCEfactor) * 2 * cableTHICK(1))
    'write #1, "validDRUMmax: " + Str(validDRUMmax)
    validDRUMmax = Int(validDRUMmax)
    'write #1, "cableCLEARANCEfactor: " + Str(cableCLEARANCEfactor)
    'write #1, "srchFRAME: " + Str(srchFRAME)
    'write #1, "cableTHICK(1): " + Str(cableTHICK(1))

    Select Case srchFRAME
      Case "14": If validDRUMmax > 10 Then validDRUMmax = 10
      Case "16": If validDRUMmax > 12 Then validDRUMmax = 12
      Case "18": If validDRUMmax > 14 Then validDRUMmax = 14
      Case "21": If validDRUMmax > 17 Then validDRUMmax = 17
      Case "24": If validDRUMmax > 20 Then validDRUMmax = 20
      Case "28": If validDRUMmax > 24 Then validDRUMmax = 24
      Case "32": If validDRUMmax > 28 Then validDRUMmax = 28
    End Select
  Case "U":
    validDRUMmax = Val(srchFRAME) - ((1 + cableCLEARANCEfactor) * 2 * cableTHICK(1))
    validDRUMmax = Int(validDRUMmax)
    'for U reels we use different calc SS
    If validDRUMmax / 2 <> Int(validDRUMmax / 2) Then validDRUMmax = validDRUMmax + 1 'round to nearest 2"
    Select Case srchFRAME
      Case "18": If validDRUMmax > 14 Then validDRUMmax = 14
      Case "21": If validDRUMmax > 17 Then validDRUMmax = 16
      Case "24": If validDRUMmax > 20 Then validDRUMmax = 18
      Case "28": If validDRUMmax > 24 Then validDRUMmax = 22
      Case "32": If validDRUMmax > 28 Then validDRUMmax = 26
    End Select
End Select

If Val(srchDRUMMAX) < validDRUMmax Then validDRUMmax = Val(srchDRUMMAX)

End Sub
Public Sub calcDRUMminMAX()
'This sub calculates the minimum drum diameter based on the cable bend
'and diameter
Dim calcDRUMminR As Single

If cableORhose = "HD" Or cableORhose = "HS" Then
  If hoseIDinINCHES > 0.5 Then
    Select Case hoseIDinINCHES
      Case Is < 0.8: calcDRUMminU = 10: calcDRUMmax = 10
      Case Is < 1.1: calcDRUMminU = 12: calcDRUMmax = 12
      Case Is < 1.3: calcDRUMminU = 14: calcDRUMmax = 14
      Case Is < 1.6: calcDRUMminU = 16: calcDRUMmax = 16
    End Select
  Else
    calcDRUMminR = (2 * cableBEND(1)) + 1
    calcDRUMmin = Int(calcDRUMminR)
    If calcDRUMmin Mod 2 <> 0 Then calcDRUMmin = calcDRUMmin + 1
    If calcDRUMmin < 10 Then
      calcDRUMminU = 10
    Else
      calcDRUMminU = calcDRUMmin
    End If
    calcDRUMmax = 26
  End If
  Model2!Text17 = calcDRUMminU
  Model2!Text18 = calcDRUMmax
  Exit Sub
End If

'calcDRUMminR = (2 * cableBEND(1) * cableTHICK(1)) + 1
calcDRUMminR = (2 * cableBEND(1)) + 1
calcDRUMmin = Int(calcDRUMminR)

'S, SM , MMD, Pendant can have min 8" drum
If calcDRUMmin < 8 Then
 calcDRUMminS = 8
 calcDRUMminSM = 8
 calcDRUMminMMD = 8
 calcDRUMminP = 8
Else
 calcDRUMminS = calcDRUMmin
 calcDRUMminSM = calcDRUMmin
 calcDRUMminMMD = calcDRUMmin
 calcDRUMminP = calcDRUMmin
End If

'U can have minimum 10" drum
If calcDRUMmin < 10 Then
 calcDRUMminU = 10
Else
If calcDRUMmin Mod 2 <> 0 Then
  calcDRUMminU = calcDRUMmin + 1
Else
 calcDRUMminU = calcDRUMmin
 End If

End If

'SHO - min drum depends on spool type
Select Case UCase(Model1!Combo15)
  Case "RANDOM WRAP":
    If calcDRUMmin < 14 Then
     calcDRUMminSHO = 14
    Else
     calcDRUMminSHO = calcDRUMmin
    End If
    calcDRUMmaxSHO = 36
  Case "MONOSPIRAL":
    If calcDRUMmin < 18 Then
     calcDRUMminSHO = 18
    Else
     calcDRUMminSHO = calcDRUMmin
    End If
    calcDRUMmaxSHO = 48
End Select

'TMR - min drum depends on spool type
Select Case UCase(Model1!Combo18)
  Case "RANDOM WRAP":
    If calcDRUMmin < 14 Then
     calcDRUMminTMR = 14
    Else
     calcDRUMminTMR = calcDRUMmin
    End If
    calcDRUMmaxTMR = 36
  Case "MONOSPIRAL":
    If calcDRUMmin < 18 Then
     calcDRUMminTMR = 18
    Else
     calcDRUMminTMR = calcDRUMmin
    End If
    calcDRUMmaxTMR = 48
End Select



Model1!Text1 = calcDRUMminS
Model1!Text7 = calcDRUMminS
Model1!Text12 = calcDRUMminS
Model1!Text32 = calcDRUMminSHO
Model1!Text33 = calcDRUMminTMR
Model1!Text17 = calcDRUMminU
Model1!Text25 = calcDRUMminP


'DEFAULT MAX DRUM FOR S
calcDRUMmaxS = 28
calcDRUMmaxSM = 28
calcDRUMmaxMMD = 28
calcDRUMmaxU = 26
calcDRUMmaxP = 28

End Sub
Public Sub lookupCOLLECTORprice()
'***************************************************************************
' This sub looks into reeldata database to get collector PRICE
'***************************************************************************
Dim reelDB As Database
Dim reelRS As Recordset
Dim SQL As String

On Error GoTo ErrorHandler

Set reelDB = DBEngine.Workspaces(0).OpenDatabase(DataDB, False, True)
SQL = "SELECT * from collectr WHERE [Collector] = '" & srchCOLL & "'"

Set reelRS = reelDB.OpenRecordset(SQL)
If reelRS.RecordCount <> 0 Then
  Select Case srchSTYLE
    Case "S": collectorPRICE = reelRS!Sprc
    Case "SM": collectorPRICE = reelRS!SMprc
    Case "MMD": collectorPRICE = reelRS!MMDprc
    Case "SHO": collectorPRICE = reelRS!SHOprc
    Case "TMR": collectorPRICE = reelRS!TMRprc
    Case "P": collectorPRICE = reelRS!Penprc
    Case "U": collectorPRICE = reelRS!Uprc
    Case "C", "HM", "K": collectorPRICE = -2  'no collector code price for CM
  End Select
Else
Select Case srchSTYLE
  Case "C", "HM", "K":
    collectorPRICE = -2  'we need to set to -2 for these three
  Case Else
    collectorPRICE = -1  'means collector price found
End Select
End If

reelRS.Close
reelDB.Close
Set reelRS = Nothing  'new
Set reelDB = Nothing
'apply price multiplier
If REELpriceMULTIPLIER > 0 And collectorPRICE > 0 Then collectorPRICE = collectorPRICE * REELpriceMULTIPLIER

Exit Sub
ErrorHandler:
Call displayERRORmessage("lookupCOLLECTORprice subroutine")

End Sub


Public Sub skipPACKAGE()
If programNAME = festoon Or programNAME = trak Or programNAME = reel Then
  cabFLAG = False: cabSKIP = True: mod2FLAG = False
  PkgIDhold = 0
  Call clearCABLEarrays
  Select Case inputCOMPLETE
    Case False:
      Select Case QuickStepResp
        Case True: Application.Show
        Case False: MainInp.Show
      End Select
    Case True: MainInp.Show
  End Select
End If
End Sub
Public Sub calcDELIVERY(a)
'***************************************************************************
' This sub calculates and stores delivery for a valid model
'***************************************************************************
'assign std delivery
Select Case UCase(validREEL(a).SERIES)
  Case "S", "MMD":
    If optANDacc(optPNTR).hazardDUTYresp Then
      stdDELIV = "4-5 weeks ARO"
    Else
      If validREEL(a).FRAME = "32" Then
        stdDELIV = "3-4 weeks ARO"
      Else
        stdDELIV = "1-2 weeks ARO"
      End If
    End If
  Case "SM":
    If validREEL(a).FRAME <> "32" Then
      If optANDacc(optPNTR).hazardDUTYresp Then
        stdDELIV = "4-5 weeks ARO"
      Else
        stdDELIV = "3 weeks ARO"
      End If
    Else
      stdDELIV = "5 weeks ARO"
    End If
  Case "SHO": stdDELIV = "4-5 weeks ARO"
  Case "TMR": stdDELIV = "10-12 weeks ARO"
  Case "C", "HM": stdDELIV = "1-2 weeks ARO"
  Case "K", "UE", "UH": stdDELIV = "2-3 weeks ARO"
  Case "P": stdDELIV = "4-5 weeks ARO"
End Select

End Sub



Public Sub writeQUOTEtoDB(whichDB As String)
'**************************************************************************
' This sub copies all quote info to temporary database for viewing.  It
' is called at the point the user wants to view the newly created quote.
'**************************************************************************
Dim myDB As Database, myTABLE As Recordset
Dim modIDhold As String, cabBUILD As String, SQL As String
Dim a As Integer, zz As Integer
Dim b As Integer, price As Integer, d As Integer, z As Integer, style As Integer
Dim Response As Integer
Dim cabLENGTHftORm As Single
Dim inTRANSflag As Boolean
Dim reelTYPEtoSTORE As Integer
Dim IDok As Boolean
Dim pkgDESCRIPTION As String
Dim pkgINSTALLprice As Single
Dim ftORm As String
Dim reelLENGTHinFTorM As String
Dim cableLENGTH As Single
Dim descrip As String
Dim WIDTHdimension As Single
Dim totalREELweight As Single
Dim totalREELprice As Single
Dim hoseFITTINGqty As Integer
Dim roundedINSTALLprice As Single

On Error GoTo ErrorHandler
inTRANSflag = False

'metver
Select Case metricDEFAULT
  Case True:
    ftORm = " m"
  Case False:
    ftORm = " ft"
End Select

Set myDB = Workspaces(0).OpenDatabase(whichDB)
'do a quick check to see if QuoteID already exists
'if so, get new quote id (this is highly unlikely)
IDok = False
Do
Set myTABLE = myDB.OpenRecordset("Select * from Quotes WHERE QuoteID = " & Chr(34) & QuoteIDhold & Chr(34) & "")
If myTABLE.RecordCount > 0 Then
  Call createQUOTEID
Else
  IDok = True
End If
myTABLE.Close
Set myTABLE = Nothing 'new
Loop Until IDok = True

'everything OK with QuoteID, continue
Workspaces(0).BeginTrans
inTRANSflag = True

'Add data to quote table
Set myTABLE = myDB.OpenRecordset("Quotes", dbOpenTable)
myTABLE.LockEdits = False
myTABLE.AddNew  ' Create new record.
If QuoteIDhold <> "" Then myTABLE("QuoteID") = QuoteIDhold   ' Set record key.
myTABLE("ProductLine") = "Reel"
If CustIDhold <> "" Then myTABLE("CustomerID") = CustIDhold ' Set company name.

'MsgBox Format(Date, "Short Date")
'myTABLE("QuoteDate") = Format(Date$, "Short Date")
myTABLE("QuoteDate").Value = Date
'myTABLE("QuoteDate") = Format(Now, "Short Date")

myTABLE("ReelQty") = QuoteForm!Text9

If QuoteForm!Text7 <> "" Then myTABLE("Subject") = QuoteForm!Text7
myTABLE("ShowDiscount") = QuoteForm!Check1.Value
If cableSAVE = True And PkgIDhold <> 0 Then myTABLE("PkgId") = PkgIDhold
myTABLE("CableIncl") = QuoteForm!Check2.Value
myTABLE("CableInstall") = QuoteForm!Check7.Value
'If QuoteForm!Text21 <> "" Then myTABLE("ExCabMoving") = Val(QuoteForm!Text21)
'myTABLE("ExCabFixed") = Val(QuoteForm!Text20)
If QuoteForm!Text20 <> "" Then myTABLE("ExCabMoving") = Val(QuoteForm!Text20)
myTABLE("ShowItem") = QuoteForm!Check3.Value
If NotesForm!Text17 <> "" Then myTABLE("Notes") = NotesForm!Text17
myTABLE("RepID") = PreparedBy
myTABLE("Status") = "Open"
myTABLE("Metric") = metricDEFAULT  'metver
myTABLE("pkgNote") = NotesForm!Text2
myTABLE.Update  ' Save changes.
myTABLE.Close   ' Close Table.
Set myTABLE = Nothing 'new
For modelTYPEtoSTORE = 1 To 2  'store recommended(quoteFLAG =1) first, then alternative(quoteFLAG =2)
  For a = 1 To recNUMBER
    reelPNTR = a
    optPNTR = validREEL(reelPNTR).selectionORDER  'points to optandacc index order

    If validREEL(reelPNTR).quoteFLAG = modelTYPEtoSTORE Then  'selected as alternative or rec.
      cableLENGTH = activeTRAVEL + QuoteForm!Text20 + validREEL(reelPNTR).extraCABLE
      'the following code was added 4/2007 per Rhonda S.
      If cableLENGTH - Int(cableLENGTH) > 0 Then
        cableLENGTH = Int(cableLENGTH) + 1
      End If

      'following code removed 4/2007
      'oldIf cableLENGTH - Val(Format(cableLENGTH, "0.0")) > 0 Then
      'old   cableLENGTH = Val(Format(cableLENGTH, "0.0")) + 0.1 ' round to nearest tenth
      'oldElse
      'old  cableLENGTH = Val(Format(cableLENGTH, "0.0"))
      'oldEnd If
      Call accessCLEARvariables
      'calculate accessory PN/prices
      Select Case validREEL(reelPNTR).SERIES
        Case "S": Call accessSreel
        Case "SM": Call accessSMreel
        Case "MMD": Call accessMMDreel
        Case "UE", "UH": Call accessUreel
        Case "C": Call accessCMreel
        Case "P": Call accessPreel
        Case "SHO", "TMR": Call accessSHOTMRreel
        Case "HM": Call accessCMreel 'uses same accessories as CM
        Case "K": Call accessKreel
      End Select

      WIDTHdimension = validREEL(reelPNTR).dimWIDTH
      totalREELweight = validREEL(reelPNTR).modelWGT
      totalREELprice = validREEL(reelPNTR).totalREELprice

      'check for hazard duty or rev rotate
      If optANDacc(optPNTR).hazardDUTYresp Then      'increase weight/dimension for hazard duty per S. Schmitz
        WIDTHdimension = WIDTHdimension + 6 '
        totalREELweight = totalREELweight + 50  '
        totalREELprice = totalREELprice + 2545  '2013 addr
      End If

      If optANDacc(optPNTR).revROTATEresp Then
          Select Case validREEL(reelPNTR).SERIES
            Case "SHO", "TMR":  'do nothing, it's a $0 adder
            Case "K"
              totalREELprice = totalREELprice + 289  '2013 adder
            Case Else  'S, SM, MMD
              totalREELprice = totalREELprice + 110  '2013 adder
          End Select
      End If

      Call calcDELIVERY(a)

      Set myTABLE = myDB.OpenRecordset("QteModel", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If QuoteIDhold <> "" Then myTABLE("QuoteID") = QuoteIDhold   ' Set record key.
      If validREEL(a).SERIES <> "" Then myTABLE("Series") = validREEL(a).SERIES
      If validREEL(a).MODELnum <> "" Then myTABLE("ModelNum") = validREEL(a).MODELnum
      myTABLE("HazardDuty") = optANDacc(optPNTR).hazardDUTYresp
      myTABLE("ReverseRotate") = optANDacc(optPNTR).revROTATEresp
      myTABLE("ReelHeight") = validREEL(a).dimHEIGHT
      myTABLE("ReelWidth") = WIDTHdimension
      myTABLE("ReelDepth") = validREEL(a).dimDEPTH
      myTABLE("ReelWeight") = totalREELweight
      myTABLE("ReqdExtraCable") = validREEL(a).extraCABLE
      If validREEL(a).quoteFLAG > 0 Then myTABLE("QuoteType") = validREEL(a).quoteFLAG
      If stdDELIV <> "" Then myTABLE("Delivery") = stdDELIV
      If validREEL(a).modelNOTE <> "" Then myTABLE("Modnote") = validREEL(a).modelNOTE
      modIDhold = myTABLE![ModelID]
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new

     'add records to quote details
     Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
     myTABLE.LockEdits = False
    myTABLE.AddNew  ' Create new record.
    If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
    myTABLE("Qty") = 1  'qty is calculated in report

    Select Case validREEL(a).SERIES
      Case "S": descrip = " Heavy Duty Cable Reel"
      Case "SM": descrip = " Extra Heavy Duty Cable Reel"
      Case "MMD": descrip = " Mill Duty Cable Reel"
      Case "SHO": descrip = " Spring-driven Cable Reel"
      Case "TMR": descrip = " Motor-driven Cable Reel"
      Case "UE": descrip = " Electric Cable Reel"
      Case "UH", "HM": descrip = " Hose Reel"
      Case "C": descrip = " Electric Cable Reel"
      Case "P": descrip = " Pendant Station Cable Reel"
      Case "K": descrip = " Dual Hose Reel"
    End Select
    myTABLE("Description") = validREEL(a).MODELnum & descrip

    If totalREELprice > 0 Then myTABLE("Price") = totalREELprice
    myTABLE.Update  ' Save changes.
    myTABLE.Close   ' Close Table.
    Set myTABLE = Nothing 'new

'   'add rollerguides to quote
    If rollerguidePN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = rollerguidePN
      myTABLE("Description") = optANDacc(optPNTR).rollerGUIDEmatl & " " & optANDacc(optPNTR).rollerGUIDEappl & " Roller Guides"
      If rollerguidePRICE > 0 Then myTABLE("Price") = rollerguidePRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

   'add hoopguides to quote
    If hoopguidePN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = hoopguidePN
      myTABLE("Description") = "Hoop Guide Assembly"
      If hoopguidePRICE > 0 Then myTABLE("Price") = hoopguidePRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add limitswitch to quote
    If limitswitchPN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = limitswitchPN
      myTABLE("Description") = "Limit Switch Assembly"
      If limitswitchPRICE > 0 Then myTABLE("Price") = limitswitchPRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add pivotbase to quote
    If pivotbasePN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = pivotbasePN
      myTABLE("Description") = "340 Degree Pivot Base"
      If pivotbasePRICE > 0 Then myTABLE("Price") = pivotbasePRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add dogratchet to quote
    If dogratchetPN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = dogratchetPN
      myTABLE("Description") = "Dog & Ratchet Assembly"
      If dogratchetPRICE > 0 Then myTABLE("Price") = dogratchetPRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add spool lock to quote
    If spoollockPN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = spoollockPN
      myTABLE("Description") = "Spool Lock Assembly"
      If spoollockPRICE > 0 Then myTABLE("Price") = spoollockPRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add ballstop to quote
    If ballstopPN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = ballstopPN
      myTABLE("Description") = "Ball Stop Assembly"
      If ballstopPRICE > 0 Then myTABLE("Price") = ballstopPRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If

    'add cable grip to quote
    If cablegripPN <> "" Then
      Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
      myTABLE.LockEdits = False
      myTABLE.AddNew  ' Create new record.
      If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
      myTABLE("Qty") = 1
      myTABLE("PN") = cablegripPN
      myTABLE("Description") = "Cable Grip Assembly"
      If cablegripPRICE > 0 Then myTABLE("Price") = cablegripPRICE
      myTABLE.Update  ' Save changes.
      myTABLE.Close   ' Close Table.
      Set myTABLE = Nothing 'new
    End If


    'add cable if requested
    If PkgIDhold <> 0 Then
      If QuoteForm!Check2.Value = 1 Then
        If validREEL(reelPNTR).SERIES = "UH" Or validREEL(reelPNTR).SERIES = "HM" Then  'For U hose we must add fittings
          Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
          myTABLE.LockEdits = False
          myTABLE.AddNew  ' Create new record.
          If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.

          If validREEL(reelPNTR).SERIES = "UH" Then
            hoseFITTINGqty = 2  '2 reqd per hose for UH
          Else
            hoseFITTINGqty = 1  ' reqd per hose for HM
          End If
          myTABLE("Qty") = hoseFITTINGqty
          myTABLE("PN") = malepipePN
          myTABLE("Description") = "Male Pipe Fitting"
          If malepipePRICE > 0 Then myTABLE("Price") = malepipePRICE
          myTABLE.Update  ' Save changes.
          myTABLE.Close   ' Close Table.

          'add clamps
          Set myTABLE = Nothing 'new
          Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
          myTABLE.LockEdits = False
          myTABLE.AddNew  ' Create new record.
          If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
          If Val(hoseIDcode) < 9 Then 'we need 1 if 1/2" or less, otherwise 2
            myTABLE("Qty") = 1
          Else
            myTABLE("Qty") = 2
          End If
          myTABLE("PN") = hoseclampPN
          myTABLE("Description") = "Clamp for Male Pipe Fitting"
          If hoseclampPRICE > 0 Then myTABLE("Price") = hoseclampPRICE
          myTABLE.Update  ' Save changes.
          myTABLE.Close   ' Close Table.
          Set myTABLE = Nothing 'new

         If Val(hoseIDcode) < 9 Then 'we need to add hose ferrules if 1/2" or less
          Set myTABLE = Nothing 'new
          Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
          myTABLE.LockEdits = False
          myTABLE.AddNew  ' Create new record.
          If modIDhold <> "" Then myTABLE("ModelID") = modIDhold   ' Set record key.
          myTABLE("Qty") = 1  '1 per hose
          myTABLE("PN") = hoseferrulePN
          myTABLE("Description") = "Hose Ferrules (1 per hose reqd)"
          If hoseferrulePRICE > 0 Then myTABLE("Price") = hoseferrulePRICE
          myTABLE.Update  ' Save changes.
          myTABLE.Close   ' Close Table.
          Set myTABLE = Nothing 'new
         End If
        End If
        Set myTABLE = myDB.OpenRecordset("Quote Details", dbOpenTable)
        myTABLE.AddNew  ' Create new record.
        myTABLE("ModelID") = modIDhold   ' Set record key.
        myTABLE("Qty") = 1
        myTABLE("PN") = Cable(1).PN
        pkgDESCRIPTION = "Cable/Hose: " & Trim(Str(cableLENGTH))
        Select Case metricDEFAULT
          Case True: pkgDESCRIPTION = pkgDESCRIPTION & " m "
          Case False: pkgDESCRIPTION = pkgDESCRIPTION & " ft "
        End Select
        Select Case cableORhose
          Case "HD", "HS":
            Select Case metricDEFAULT
              Case True: pkgDESCRIPTION = pkgDESCRIPTION & LCase(Cable(1).style) & ", " & Cable(1).ID & " mm" & " I.D. "
              Case False: pkgDESCRIPTION = pkgDESCRIPTION & LCase(Cable(1).style) & ", " & Cable(1).ID & Chr(34) & " I.D. "
            End Select
            If cableORhose = "HD" Then pkgDESCRIPTION = pkgDESCRIPTION & "w/fittings"
          Case Else:
           pkgDESCRIPTION = pkgDESCRIPTION & "Round "
           If Cable(1).itemTYPE = "O" Or Cable(1).itemTYPE = "HV" Then 'High Voltage Cable
               Select Case Val(Cable(1).VOLTAGE)
                 Case 600: pkgDESCRIPTION = pkgDESCRIPTION & "600V "
                 Case 5000: pkgDESCRIPTION = pkgDESCRIPTION & "5 KV "
                 Case 8000: pkgDESCRIPTION = pkgDESCRIPTION & "8 KV "
                 Case 15000: pkgDESCRIPTION = pkgDESCRIPTION & "15 KV "
               End Select
           Else
              pkgDESCRIPTION = pkgDESCRIPTION & Cable(1).itemTYPE & Space(1)
           End If

           pkgDESCRIPTION = pkgDESCRIPTION & Cable(1).COND & "C-"
           Select Case metricDEFAULT
             Case True
               pkgDESCRIPTION = pkgDESCRIPTION & Cable(1).AWG & "mm2"
             Case False:
               pkgDESCRIPTION = pkgDESCRIPTION & Cable(1).AWG & "AWG"
           End Select
           pkgDESCRIPTION = pkgDESCRIPTION & " Cable"
        End Select
        myTABLE("Description") = pkgDESCRIPTION & "*"
        'If cableORhose = "C" And Cable(1).PN <> "Special" And QuoteForm!Check7.Value = 1 Then  'user selected cable installation  'jpm
        If cableORhose = "C" And Val(Cable(1).INSTALLfixed) > 0 And QuoteForm!Check7.Value = 1 Then
           'add in installation cost
           roundedINSTALLprice = Val(Cable(1).INSTALLfixed) + (Val(Cable(1).INSTALLfoot) * cableLENGTH)
           'now round it so price/length is 2 decimals
           'old roundedINSTALLprice = Int((roundedINSTALLprice / cableLENGTH) * 100) + 1 'round to next dime
           'make sure the cost per foot is even (so half foot increments work)
           'old If roundedINSTALLprice / 2 <> Int(roundedINSTALLprice / 2) Then roundedINSTALLprice = roundedINSTALLprice + 1 'round to next dime
           'old roundedINSTALLprice = (roundedINSTALLprice / 100) * cableLENGTH
           myTABLE("Price") = roundedINSTALLprice
        Else
          myTABLE("Price") = (cableLENGTH * Val(Cable(1).PRICE))
        End If
        myTABLE.Update  ' Save changes.
     End If
   End If
 End If
  'if securityCODE = 5 remove all pricing
    If securityCODE = 5 Then
      SQL = "Update [Quote Details] SET [Price] = " & 0 & " Where [ModelID] = " & modIDhold
      myDB.Execute SQL
    End If
Next a
Next modelTYPEtoSTORE  'looked for models designated 'alternative


'add application parameters
Set myTABLE = myDB.OpenRecordset("ReelApp", dbOpenTable)
  myTABLE.LockEdits = False
  myTABLE.AddNew  ' Create new record.
  myTABLE("QuoteID") = QuoteIDhold   ' Set record key.
  myTABLE("Travel") = activeTRAVEL
  myTABLE("Speed") = systemSPEED
  myTABLE("Accel") = systemACCEL
  myTABLE("Application") = reelAPPLICATION
  Select Case Left(reelAPPLICATION, 1)
    Case "L", "M": myTABLE("PendantWgt") = pendantWEIGHT
    Case "S": myTABLE("SAG") = percentSAGstr
    Case "R", "H": myTABLE("CenterlineHgt") = centerlineHEIGHT
  End Select
  myTABLE("Duty Cycle") = dutyCYCLE
  myTABLE("TempMin") = ambTEMPmin
  myTABLE("TempMax") = ambTEMPmax
  myTABLE("AppNote") = NotesForm!Text1
  myTABLE.Update
myTABLE.Close   ' Close Table.
Set myTABLE = Nothing 'new

Set myTABLE = myDB.OpenRecordset("QteDisc", dbOpenTable)
myTABLE.LockEdits = False
myTABLE.AddNew
myTABLE("QuoteID") = QuoteIDhold   ' Set record key.
For zz = 1 To numREELquoted
  'MsgBox QuoteForm!text2(zz).DataField
  'MsgBox QuoteForm!Text13(zz).DataField
  If QuoteForm!Text2(zz) <> "" Then myTABLE(QuoteForm!Text2(zz).DataField) = QuoteForm!Text2(zz)
  If QuoteForm!Text13(zz) <> "" Then myTABLE(QuoteForm!Text13(zz).DataField) = QuoteForm!Text13(zz)
Next zz
myTABLE.Update
myTABLE.Close
Set myTABLE = Nothing 'new

Workspaces(0).CommitTrans
inTRANSflag = False
myDB.Close
Set myDB = Nothing 'new

Exit Sub

ErrorHandler:
If inTRANSflag = True Then Workspaces(0).Rollback
Call displayERRORmessage("writeQuotetoDB sub")
Call exitITEM(0)

End Sub



























Public Sub findTHEreel()
'***************************************************************************
' This sub is part of the main search of reels.  It is used to pull out a
' recordset of all the reels a user wants to consider. Once a recordset is
' created, loopTHRUreels is called to check each reel.
'***************************************************************************
Dim SQL As String 'this will be a DB query'
Dim intFileNbr As Integer 'integer: File Number??'
On Error GoTo ErrorHandler
'''''reelDETLfileNAME = "reeldetl" & Format(Int(Rnd * 10000), "0000") & ".txt"
reelDETLfileNAME = "reeldetl.txt"
intFileNbr = FreeFile 'get's a file # that can be used by FileOpen
Open BackUpPath & reelDETLfileNAME For Output Shared As #intFileNbr 'we are opening two files for us to output to, the Shared ketword let's other applications access the files freely
  Call writeDETAILSappl
'Open "price:\temp\stest.txt" For Output Shared As #1
'Open "price:\temp\klist.txt" For Output Shared As #2
Set searchDB = DBEngine.Workspaces(0).OpenDatabase(DataDB, False, True)
Call getSPRINGdata

'Pull up requested S-Reels, if any
If Smodels = "All" Or Smodels = "Some" Then 'if we want all or some of the s-reel modles then:
  Searching!Label1.Caption = "Searching S-Reels ....." 'gui
  Searching!Label1.Refresh 'gui
  SQL = "SELECT * from SSMMMD WHERE [STYLE] = 'S'" 'S, SM, and MMD are all the cable reel series that gleason sells. so SSMMMD is the table of all cale reels, S is the specific type we are looking for
  Select Case Smodels
    Case "All":  'look at all S Reels
    Case "Some": SQL = SQL & " and " & SframeLIST
  End Select

  Select Case SspringSEL 'allows us to search for a specific spring type
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(SspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(SspringSEL, Len(SspringSEL) - 1) & "*" & Chr(34) 'Chr(34) is the character value for " so this is a lazy ass method of concatinating in "" to be semi sql safe
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & SspringSEL & Chr(34)
      End If
  End Select

  Select Case SgearSEL
    Case "None": SQL = SQL & " and [GEAR] = ''" 'we don't want a gear at all
    Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & SgearSEL & Chr(34)
  End Select
  SQL = SQL & " order BY [COST],[GEAR]" 'standard sql sort
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 1
  Call loopTHRUreels("S Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If


'Pull up requested MMD Reels, if any
If MMDmodels = "All" Or MMDmodels = "Some" Then 'this is the same as above, just for MMD reels
  Searching!Label1.Caption = "Searching MMD-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from SSMMMD WHERE [STYLE] = 'MMD'"
  Select Case MMDmodels
    Case "All":  'look at all S Reels
    Case "Some": SQL = SQL & " and " & MMDframeLIST
  End Select

  Select Case MMDspringSEL
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(MMDspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(MMDspringSEL, Len(MMDspringSEL) - 1) & "*" & Chr(34)
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & MMDspringSEL & Chr(34)
      End If
  End Select

  Select Case MMDgearSEL
    Case "None": SQL = SQL & " and [GEAR] = ''"
    Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & MMDgearSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST],[GEAR]"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 2
  Call loopTHRUreels("MMD Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested SM Reels, if any
If SMmodels = "All" Or SMmodels = "Some" Then 'again, same as before
  Searching!Label1.Caption = "Searching SM-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from SSMMMD WHERE [STYLE] = 'SM'"
  Select Case SMmodels
    Case "All":  'look at all S Reels
    Case "Some": SQL = SQL & " and " & SMframeLIST
  End Select

  Select Case SMspringSEL
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(SMspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(SMspringSEL, Len(SMspringSEL) - 1) & "*" & Chr(34)
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & SMspringSEL & Chr(34)
      End If
  End Select

  Select Case SMgearSEL
    Case "None": SQL = SQL & " and [GEAR] = ''"
    Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & SMgearSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST], [GEAR]"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 3
  Call loopTHRUreels("SM Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested SHO Reels, if any
If SHOmodels = "All" Or SHOmodels = "Some" Then
  Searching!Label1.Caption = "Searching SHO-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from SHO WHERE [STYLE] = 'SHO' and [Stype] = " & Chr(34) & SHOspoolmethodSEL & Chr(34) 'SHO is another type of reel they offer, other than that same as before

  Select Case SHOspringSEL
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(SHOspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(SHOspringSEL, Len(SHOspringSEL) - 1) & "*" & Chr(34)
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & SHOspringSEL & Chr(34)
      End If
  End Select

  If SHOspoolmethodSEL = "R" Then 'they have multiple spool types for these models, so we must pick one
    Select Case SHOspoolwidthSEL
      Case "All":
      Case Else: SQL = SQL & " and [Swidth] = " & Chr(34) & SHOspoolwidthSEL & Chr(34)
    End Select
  End If

  Select Case SHOspooldiamSEL 'finding spool diameter
   Case "All":
   Case Else: SQL = SQL & " and [Sdiam] = " & Chr(34) & SHOspooldiamSEL & Chr(34)
  End Select

  Select Case SHOchainratioSEL 'these are chain assisted, so we need to know how much chain we want to drive the reel
     Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & SHOchainratioSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST],[GEAR] DESC"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 0
  Call loopTHRUreels("SHO Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested TMR reels if any
If TMRmodels = "All" Or TMRmodels = "Some" Then 'motor driven reels, only special stuff is motor type selection, these use torque motors with a chain, so the chain will be selected again
  Searching!Label1.Caption = "Searching TMR-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from TMR WHERE [STYLE] = 'TMR' and [Stype] = " & Chr(34) & TMRspoolmethodSEL & Chr(34)

  Select Case TMRmotorSEL
    Case "All":  'do not add any motor criteria
    Case Else: SQL = SQL & " and [motor] = " & Chr(34) & TMRmotorSEL & Chr(34)
  End Select

  If TMRspoolmethodSEL = "R" Then
    Select Case TMRspoolwidthSEL
      Case "All":
      Case Else: SQL = SQL & " and [Swidth] = " & Chr(34) & TMRspoolwidthSEL & Chr(34)
    End Select
  End If

  Select Case TMRspooldiamSEL
   Case "All":
   Case Else: SQL = SQL & " and [Sdiam] = " & Chr(34) & TMRspooldiamSEL & Chr(34)
  End Select

  Select Case TMRchainratioSEL
     Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & TMRchainratioSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST],[GEAR] DESC"
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 0
  Call loopTHRUreels("TMR Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested CM-Reels, if any
If CMmodels = "All" Or CMmodels = "Some" Then 'same shit new model
  Searching!Label1.Caption = "Searching CM-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from CM WHERE [STYLE] = 'C'"
  Select Case CMmodels
    Case "All":  'look at all CM Reels
    Case "Some": SQL = SQL & " and " & CMframeLIST
  End Select

  Select Case CMcollSEL
    Case "All":  'do not add any collector criteria
    Case Else: SQL = SQL & " and [WIRE] = " & Chr(34) & CMcollSEL & Chr(34)
  End Select

  Select Case CMspringSEL
    Case "All":  'ALL do not add any spring criteria
    'Case "U", "V": SQL = SQL & " and ([SPRINGS] = 'U' or [SPRINGS] = 'V')"
    Case Else:
      SQL = SQL & " and [SPRINGS] = " & Chr(34) & CMspringSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST]"
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 4
  Call loopTHRUreels("CM Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested U Reels, if any
If Umodels = "All" Or Umodels = "Some" Then
  Searching!Label1.Caption = "Searching U-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from U WHERE [STYLE] = 'U'"
  Select Case Umodels
    Case "All":  'look at all S Reels
    Case "Some": SQL = SQL & " and " & UframeLIST
  End Select

  Select Case UspringSEL
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(UspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(UspringSEL, Len(UspringSEL) - 1) & "*" & Chr(34)
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & UspringSEL & Chr(34)
      End If
  End Select

  Select Case UgearSEL
    Case "None": SQL = SQL & " and [GEAR] = ''"
    Case "All":
    Case Else: SQL = SQL & " and [GEAR] = " & Chr(34) & UgearSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST],[GEAR]"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 5
  Call loopTHRUreels("U Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested Pendant-Reels, if any
If Pmodels = "All" Or Pmodels = "Some" Then
  Searching!Label1.Caption = "Searching Pendant Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from P WHERE [STYLE] = 'P'"
  Select Case Pmodels
    Case "All":  'look at all CM Reels
    Case "Some": SQL = SQL & " and " & PframeLIST
  End Select

  Select Case PmotorSEL
    Case "All":  'do not add any collector criteria
    Case Else: SQL = SQL & " and [MOTOR] = " & Chr(34) & PmotorSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST]"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 6
  Call loopTHRUreels("P Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested HM-Reels, if any
If HMmodels = "All" Or HMmodels = "Some" Then
  Searching!Label1.Caption = "Searching HM-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from HM WHERE [STYLE] = 'HM' and [Hose] = " & Chr(34) & hoseIDcode & Chr(34)
  Select Case HMmodels
    Case "All":  'look at all HM Reels
    Case "Some": SQL = SQL & " and " & HMframeLIST
  End Select

  Select Case HMspringSEL
    Case "All":  'ALL do not add any spring criteria
    'Case "EZ": SQL = SQL & " and ([SPRINGS] = 'U' or [SPRINGS] = 'V')"
    Case Else:
      SQL = SQL & " and [SPRINGS] = " & Chr(34) & HMspringSEL & Chr(34)
  End Select

  SQL = SQL & " order BY [COST]"
  'MsgBox SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 8
  Call loopTHRUreels("HM Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If

'Pull up requested K-Reels, if any
If Kmodels = "All" Or Kmodels = "Some" Then
  Searching!Label1.Caption = "Searching K-Reels ....."
  Searching!Label1.Refresh
  SQL = "SELECT * from K WHERE [STYLE] = 'K' and [HoseID] = " & Chr(34) & hoseIDcode & Chr(34)
  Select Case Kmodels
    Case "All":  'look at all K Reels
    Case "Some": SQL = SQL & " and " & KframeLIST
  End Select
  Select Case KspringSEL
    Case "All":  'do not add any spring criteria
    Case Else:
      If Right(KspringSEL, 1) = "X" Then
       SQL = SQL & " and [SPRINGS] like " & Chr(34) & Left(KspringSEL, Len(KspringSEL) - 1) & "*" & Chr(34)
      Else
        SQL = SQL & " and [SPRINGS] = " & Chr(34) & KspringSEL & Chr(34)
      End If
  End Select
  SQL = SQL & " order BY [COST]"
  'write #1, SQL
  Set searchRS = searchDB.OpenRecordset(SQL)
  modelINDEX = 7
  Call loopTHRUreels("K Reel")
  searchRS.Close
  Set searchRS = Nothing 'new
End If


searchDB.Close
Set searchRS = Nothing 'new
'Close #2
Close #1

'if last reel checked did not have price, don't use
If validPRICEfound = False Then
  recNUMBER = recNUMBER - 1
  If recNUMBER = 0 Then validREELSfound = False
End If

Screen.MousePointer = 1
If validREELSfound = True Then  'valid reels are found
  Searching!Gauge = 100
  Searching!Label2.Caption = 100
  Searching.Refresh
  noneVALID = False
  'Call pullOUTbestREELS
  SrchRslt.Show  'show results
Else
  noneVALID = True
  Invalid.Show
End If

Unload Searching
Set Searching = Nothing

Exit Sub
ErrorHandler:
  Close #1
  Call displayERRORmessage("findTHEreel subroutine")

End Sub



'Not in use, ignore
Public Sub checkSPEED()
'***************************************************************************
' This sub checks if speed required is valid for reel
'***************************************************************************
' values per S. Schmitz 9/25/97
Dim maxSPEED As Integer

'If traysREQD = False And carrsysREQD = False Then
'  Select Case Left$(searchRS!Model, 3)
'    Case "049": maxSPEED = 985

' End Select
'Else
'   Select Case Left$(searchRS!Model, 3)
'    Case "101": maxSPEED = 300
'   End Select
'End If

'If speedINftsec > maxSPEED Then Exit Sub
'validSPEED = True

End Sub



Public Sub Main()
Screen.MousePointer = 11
versionNO = "2013-3.0"
With Intro
  .Show
  .Refresh
  .Timer1.Enabled = True
End With
End Sub

Public Sub invalidSTORE(reason As Integer)
'***************************************************************************
' If a reel is not valid, this sub stores the model and reason in an array
' which can be viewed by user on Invalid.form.  This sub can be called
' several times for a given model - if it is invalid for several reasons.
'***************************************************************************
Dim Model As String, CARRIER As String, BEND As String

'If reelINVALID = False Then  'first time in sub for this model, increment counter
  invalidCOUNT = invalidCOUNT + 1
  ReDim Preserve invalidREEL(invalidCOUNT) As invalidRESULT
  reelINVALID = True
  invalidREEL(invalidCOUNT).invalidMODEL = modelNO

'store reasons for being invalid
invalidREEL(invalidCOUNT).invalidREASON(reason) = True

End Sub

Public Sub loopTHRUreels(reelTYPE As String)
'***************************************************************************
' This is the heart of the program.  All the reels pulled up in findTHEreel
' are looped through in this routine.  The reels are put through several
' validity tests and if they pass they are stored in the valid reel array.
' If a user selects 'All' instead of specifying a model, only the first two
' valid reels are stored.
'***************************************************************************
Dim numRECORDSchecked As Integer, donePERCENT As Integer 'Number of records that are checked, how much percentage of reels checked
Dim msg As String
Dim numRECORDS As Integer 'number of records being checked for validity
Dim i As Integer, j As Integer, k As Integer 'Looping variables?

Dim modelSTR As String
Dim collSTR As String
Dim motorSTR As String
Dim spoolwidthSTR As String
Dim spooldiamSTR As String
Dim springSTR As String
Dim drumINCREMENT As Integer
Dim fileSTR As String
'STR = String

On Error GoTo ErrorHandler
validPRICEfound = True 'this only set to false when previous record had no price
invalidWARNING = False

' check if any records selected
If securityCODE <> 99 Then 'What is the <> operator?
  If searchRS.RecordCount = 0 Then 'No returned results
    'Output
    MsgBox "Note: Based on the search criteria given, no " & reelTYPE & " models would be considered for this application.  Double check that the search criteria you have entered for this model is valid."
    Exit Subbn 'What does this do? I'm guessing exit subroutine, but why didn't he just do a if else?
  End If
End If
'get recordcount
searchRS.MoveLast 'Move to last item in searchRS?
numRECORDS = searchRS.RecordCount
searchRS.MoveFirst 'Move to the first item?
numRECORDSchecked = 0  'counts number of db records we have looked at

'-------------- LOOP STARTS HERE -----------------------------------------

'fileSTR = "TRAVEL: " & Str(travelINft)
'fileSTR = fileSTR & "   APP: " & reelAPPLICATION
'fileSTR = fileSTR & "   SPEED: " & Str(speedINftsec)
'fileSTR = fileSTR & "   ACCEL: " & Str(systemACCEL)
'fileSTR = fileSTR & "   CCF: " & Str(cableCLEARANCEfactor)
'fileSTR = fileSTR & "   Turns %: " & TURNSusedPERCENTstr
'fileSTR = fileSTR & "   Dead Wraps: " & Str(deadWRAPS)
''write #1, fileSTR
''write #1, "******************************************************"


Do Until searchRS.EOF = True 'run through all records
  numRECORDSchecked = numRECORDSchecked + 1
  'displays search status/% complete
  donePERCENT = Int((numRECORDSchecked / numRECORDS) * 100) 'I'm supposing we might need to display this if it takes a long time?
  Searching!Gauge = donePERCENT 'What does ! operator do?
  Searching!Label2.Caption = donePERCENT
  Searching!Gauge.Refresh
  Call clearSEARCHcriteria '

  srchSTYLE = searchRS!style
  srchCOST = searchRS!COST
  Select Case srchSTYLE
    Case "S", "SM", "MMD", "U":
     drumINCREMENT = 1
     srchFRAME = searchRS!FRAME
     srchSPRING = searchRS!SPRINGS
     If searchRS!gear <> "" Then srchGEAR = searchRS!gear
     Select Case searchRS!style
       Case "S":
         srchCOLL = ScollSEL
         srchDRUMMIN = SdrumminSEL
         srchDRUMMAX = SdrummaxSEL
         srchPREMIN = SpreminSEL
         srchPREMAX = SpremaxSEL
       Case "SM":
         srchCOLL = SMcollSEL
         srchDRUMMIN = SMdrumminSEL
         srchDRUMMAX = SMdrummaxSEL
         srchPREMIN = SMpreminSEL
         srchPREMAX = SMpremaxSEL
       Case "MMD":
         srchCOLL = MMDcollSEL
         srchDRUMMIN = MMDdrumminSEL
         srchDRUMMAX = MMDdrummaxSEL
         srchPREMIN = MMDpreminSEL
         srchPREMAX = MMDpremaxSEL
       Case "U":
         drumINCREMENT = 2
         srchCOLL = UcollSEL
         srchDRUMMIN = UdrumminSEL
         srchDRUMMAX = UdrummaxSEL
         srchPREMIN = UpreminSEL
         srchPREMAX = UpremaxSEL
      End Select
    Case "SHO":
     drumINCREMENT = 2
     srchSPOOLMETHOD = searchRS!stype
     srchSPRING = searchRS!SPRINGS
     If srchSPOOLMETHOD = "M" Then
       srchSPOOLWIDTH = SHOspoolwidthSEL
     Else
       If Len(Trim(searchRS!swidth)) > 0 Then srchSPOOLWIDTH = searchRS!swidth
     End If
     srchFRAME = Trim(searchRS!sdiam)
     srchGEAR = searchRS!gear
     srchCOLL = SHOcollSEL
     If Val(srchFRAME) = 54 And srchSPOOLMETHOD = "R" And SHOdrumminSEL < 18 Then
       srchDRUMMIN = 18
     Else
       srchDRUMMIN = SHOdrumminSEL
     End If
     srchDRUMMIN = SHOdrumminSEL
     srchDRUMMAX = SHOdrummaxSEL
     srchPREMIN = SHOpreminSEL
     srchPREMAX = SHOpremaxSEL
    Case "TMR":
     drumINCREMENT = 2
     srchSPOOLMETHOD = searchRS!stype
     srchMOTOR = Trim(searchRS!MOTOR)
     If srchSPOOLMETHOD = "M" Then
       srchSPOOLWIDTH = TMRspoolwidthSEL
     Else
       If Len(Trim(searchRS!swidth)) > 0 Then srchSPOOLWIDTH = searchRS!swidth
     End If
     srchFRAME = Trim(searchRS!sdiam)
     srchGEAR = searchRS!gear
     srchCOLL = TMRcollSEL
     If Val(srchFRAME) = 54 And srchSPOOLMETHOD = "R" And TMRdrumminSEL < 18 Then
       srchDRUMMIN = 18
     Else
       srchDRUMMIN = TMRdrumminSEL
     End If
     srchDRUMMAX = TMRdrummaxSEL
     srchPREMIN = ""
     srchPREMAX = ""
    Case "C":
     srchFRAME = searchRS!FRAME
     srchCOLL = searchRS!wire
     srchSPRING = searchRS!SPRINGS
     srchDRUMMIN = ""
     srchDRUMMAX = ""
     srchPREMIN = CMpreminSEL
     srchPREMAX = CMpremaxSEL
     srchGEAR = ""
    Case "P":
     drumINCREMENT = 1
     srchFRAME = searchRS!FRAME
     srchMOTOR = searchRS!MOTOR
     srchCOLL = PcollSEL
     srchDRUMMIN = PdrumminSEL
     srchDRUMMAX = PdrummaxSEL
     srchPREMIN = ""
     srchPREMAX = ""
    Case "K"
     srchFRAME = searchRS!FRAME
     srchSPRING = searchRS!SPRINGS
     srchPREMIN = KpreminSEL
     srchPREMAX = KpremaxSEL
   Case "HM":
     srchFRAME = searchRS!FRAME
     srchSPRING = searchRS!SPRINGS
     srchDRUMMIN = ""
     srchDRUMMAX = ""
     srchPREMIN = HMpreminSEL
     srchPREMAX = HMpremaxSEL
     srchGEAR = ""
 End Select

 If srchSTYLE <> "C" And srchSTYLE <> "K" And srchSTYLE <> "HM" Then
  Call checkDRUMsize
  'write #1, "srchDRUMMIN: " & Str(srchDRUMMIN)
  ''write #1, "srchDRUMMAX: " & Str(srchDRUMMAX)
  ''write #1, "validDRUMmax: " & Str(validDRUMmax)
  If validDRUMmax < Val(srchDRUMMIN) Then
   ''write #1, "Drum violation"
    GoTo nextREEL
  End If
 End If

 If reelAPPLICATION = "Hand Pull" Then
   If Left(srchSPRING, 3) = "100" Then GoTo nextREEL
   If (srchSTYLE = "C" Or srchSTYLE = "HM") And (srchSPRING <> "U" And srchSPRING <> "V") Then GoTo nextREEL
 End If

 Call checkPRETENSturns
' 'write #1, "srchPREMIN: " & Str(srchPREMIN)
  ''write #1, "validPRETENSmax: " & Str(validPRETENSmax)
 'IF LTRIM$(reelTYPEdisplayed) = "SW" AND VAL(srchFRAME) < 16 THEN GOTO next.s2reel.key
 'IF LTRIM$(reelTYPEdisplayed) = "SW" AND VAL(srchFRAME) > 24 THEN GOTO next.s2reel.key
  If srchSTYLE = "TMR" Or srchSTYLE = "P" Then
    srchPREMIN = 0
    validPRETENSmax = 0
  End If


  If srchSTYLE = "C" Or srchSTYLE = "HM" Then
    validDRUMmax = 0
    srchDRUMMIN = "1"
    drumINCREMENT = -1
  End If

  If srchSTYLE = "K" Then
    Select Case hoseIDcode
      Case "4", "6", "8":
        validDRUMmax = 9
        srchDRUMMIN = "9"
        drumINCREMENT = 1
      Case "12":
        validDRUMmax = 14
        srchDRUMMIN = "14"
        drumINCREMENT = 1
    End Select
  End If



 frameSIZE = Val(srchFRAME)
 springSIZE = Val(srchSPRING)
 Call assignGEARratio(srchGEAR)
 If srchSTYLE = "TMR" Then gearRATIO = gearRATIO * 5.8
 For drumSIZE = validDRUMmax To Val(srchDRUMMIN) Step -drumINCREMENT
   For pretensionTURNS = Val(srchPREMIN) To validPRETENSmax
     ''write #1, "INITIAL CALCS:"
     If srchSTYLE = "C" Or srchSTYLE = "HM" Then
       Call doINITIALCMcalcs
     Else
       Call doINITIALcalcs
     End If

     If validCOMPARTMENT = False Then GoTo pretensSKIP

     If validTURNS = True Then
       validTORQUE = False
       If srchSTYLE = "C" Or srchSTYLE = "HM" Then
         Select Case Left$(reelAPPLICATION, 1)
           Case "L", "M": Call calcLIFTapplCM
           Case "S": Call calcSTRETCHapplCM
           Case "R", "H": Call calcRETRIEVEapplCM
         End Select
       Else
         Select Case Left$(reelAPPLICATION, 1)
           Case "L", "M": Call calcLIFTappl
           Case "S": Call calcSTRETCHappl
           Case "R", "H": Call calcRETRIEVEappl
         End Select
       End If

       If srchSTYLE = "SHO" Or srchSTYLE = "TMR" Then
         Call calcSTRESSbearing
         If validSTRESS = True And validTORQUE = True Then GoTo modelFOUND
       End If

       If validTORQUE = True Then GoTo modelFOUND

     End If
   Next pretensionTURNS
pretensSKIP:
 Next drumSIZE
GoTo nextREEL

'***************************************************************
'valid model found!!!
'***************************************************************
modelFOUND:
recNUMBER = recNUMBER + 1


 validREELSfound = True
''write #1, "VALID MODEL FOUND: " & modelNO$
''write #1, "END RUN"
''write #1, ""
''write #1, ""

Call calcMODELweight
Call calcMODELdimensions
Call calcREELprice
Call calcEXTRAcable

'load valid reel info into array--------------------------------------------------------------------------------------------------------------------
ReDim Preserve validREEL(recNUMBER) As reelDATA
validREEL(recNUMBER).MODELnum = modelNO
If srchSTYLE = "U" Then
  Select Case cableORhose
    Case "C": validREEL(recNUMBER).SERIES = "UE"
    Case Else: validREEL(recNUMBER).SERIES = "UH"
  End Select
Else
  validREEL(recNUMBER).SERIES = srchSTYLE
End If
validREEL(recNUMBER).FRAME = srchFRAME
validREEL(recNUMBER).SPRING = srchSPRING
validREEL(recNUMBER).COLL = srchCOLL
validREEL(recNUMBER).COLLECTORCOST = collectorPRICE
If validREEL(recNUMBER).COLLECTORCOST < 0 Then validREEL(recNUMBER).COLLECTORCOST = 0
validREEL(recNUMBER).PRETENSION = pretensionTURNS
validREEL(recNUMBER).drum = drumSIZE
validREEL(recNUMBER).MOTOR = srchMOTOR
validREEL(recNUMBER).SPOOLWIDTH = srchSPOOLWIDTH
validREEL(recNUMBER).SPOOLDIAM = srchFRAME
Select Case metricDEFAULT
  Case True:
    validREEL(recNUMBER).modelWGT = Val(Format(modelWEIGHT * 0.45359, "0.0"))
    validREEL(recNUMBER).dimWIDTH = Val(Format(dimensWIDTH * 25.4, "0"))
    validREEL(recNUMBER).dimHEIGHT = Val(Format(dimensHEIGHT * 25.4, "0"))
    validREEL(recNUMBER).dimDEPTH = Val(Format(dimensDEPTH * 25.4, "0"))
    validREEL(recNUMBER).extraCABLE = Val(Format(extraCABLEatREEL * 0.3048, "0.0"))
  Case False:
    validREEL(recNUMBER).modelWGT = modelWEIGHT
    validREEL(recNUMBER).dimWIDTH = dimensWIDTH
    validREEL(recNUMBER).dimHEIGHT = dimensHEIGHT
    validREEL(recNUMBER).dimDEPTH = dimensDEPTH
    validREEL(recNUMBER).extraCABLE = extraCABLEatREEL
End Select

validREEL(recNUMBER).turnsLIMIT = availSPRINGturns
validREEL(recNUMBER).compartmentCAPACITY = Format(compartmentACTIVEcableLENGTH, "#.##")
validREEL(recNUMBER).turnsCAPACITY = Format(turnsACTIVEcableLENGTH, "#.##")

Select Case Left(reelAPPLICATION, 1)
  Case "L", "M":
    validREEL(recNUMBER).torqWfullREEL = Format(netTORQUEwithREELfullLIFT, "#.##")
    validREEL(recNUMBER).torqueCAPACITY = Format(maxACTIVElengthOFcableFROMtorqueLIFT, "#.##")
    validREEL(recNUMBER).maxCAPACITY = Format(maxLIFTcapacityOFreel, "#.##")
  Case "S":
    validREEL(recNUMBER).torqWfullREEL = Format(netTORQUEwithREELfullSTRETCH, "#.##")
    validREEL(recNUMBER).torqueCAPACITY = Format(maxACTIVElengthOFcableFROMtorqueSTRETCH, "#.##")
    validREEL(recNUMBER).maxCAPACITY = Format(maxSTRETCHcapacityOFreel, "#.##")
  Case "R", "H":
    validREEL(recNUMBER).torqWfullREEL = Format(netTORQUEwithREELfullRETRIEVE, "#.##")
    validREEL(recNUMBER).torqueCAPACITY = Format(maxCENTERLINEheight, "#.##")
    validREEL(recNUMBER).maxCAPACITY = Format(maximumRETRIEVEcapacityOFreel, "#.##")
End Select

validREEL(recNUMBER).quoteFLAG = 3
validREEL(recNUMBER).totalREELprice = reelTOTALlistPrice
validREEL(recNUMBER).invalidWARN = invalidWARNING
validREEL(recNUMBER).locationPOINTER = recNUMBER

Call writeDETAILSsummary

'Call getPRICEmultipliers(validREEL(recNUMBER).SERIES)
'Call clearVARIABLES

Exit Do

nextREEL:
  searchRS.MoveNext
Loop
srchOVER:

Exit Sub
ErrorHandler:
  Call displayERRORmessage("loopTHRUreels subroutine")
End Sub


Public Sub clearQTE()
'***************************************************************************
' This sub clears out arrays and variables so that a new quote can begin
'***************************************************************************
Call clearARRAYS
Call clearCABLEarrays
reelAPPLICATION = ""
quoteCOMPLETE = False
cabSKIP = False
custFLAG = False: mod1FLAG = False: mod2FLAG = False: appFLAG = False: cabFLAG = False
inputCOMPLETE = False
qteID = ""
QuoteIDhold = ""
CustIDhold = ""
existingPKGS = False

End Sub








Public Sub delQUOTE(tempORmain As String, DELqteID As String, DELpkgID As Integer)
'***************************************************************************
' This sub deletes a quote from the main database
'***************************************************************************
Dim remQTEdb As Database, modIDtable As Recordset
Dim SQL As String
Dim inTRANSflag As Boolean

On Error GoTo ErrorHandler
inTRANSflag = False
QTEinUSE = False

Set remQTEdb = Workspaces(0).OpenDatabase(QuoteDB)

Workspaces(0).BeginTrans
inTRANSflag = True
'get modelID
Set modIDtable = remQTEdb.OpenRecordset("SELECT * FROM [QteModel] where QuoteID = " & Chr(34) & DELqteID & Chr(34) & "")
modIDtable.LockEdits = False
Do Until modIDtable.EOF = True
  'remove records from quotedetails
  SQL = "DELETE * From [Quote Details] WHERE  ModelID = " & modIDtable!ModelID & ""
  remQTEdb.Execute SQL

  'remove record from QteModel
  SQL = "DELETE * From [QteModel] WHERE  ModelID = " & modIDtable!ModelID & ""
  remQTEdb.Execute SQL
  modIDtable.MoveNext
Loop
modIDtable.Close
Set modIDtable = Nothing 'new


'remove record from ReelApp database
SQL = "DELETE * From ReelApp WHERE QuoteID = " & Chr(34) & DELqteID & Chr(34) & ""
remQTEdb.Execute SQL

'remove record from qteDISC database
SQL = "DELETE * From qteDISC WHERE QuoteID = " & Chr(34) & DELqteID & Chr(34) & ""
remQTEdb.Execute SQL

'remove record from quote database
SQL = "DELETE * From Quotes WHERE QuoteID = " & Chr(34) & DELqteID & Chr(34) & ""
remQTEdb.Execute SQL


Workspaces(0).CommitTrans
inTRANSflag = False
remQTEdb.Close
Set remQTEdb = Nothing 'new

Exit Sub

ErrorHandler:
If inTRANSflag = True Then Workspaces(0).Rollback
Select Case Err.Number
 Case 3186:
  MsgBox "Quote " & DELqteID & " is currently in use by another user and cannot be deleted at this time."
 Case Else
  Call displayERRORmessage("delQUOTE subroutine")
End Select
Call exitITEM(0)
End Sub




Public Sub checkQUOTEdb()
'***************************************************************************
' This sub checks is used to see if an quotes are in database.  If not, we
' disable the ability to modify, view and delete quotes.
' Also looks at cable packages & customers and disables menu items if there are none
'***************************************************************************
Dim myDB As Database, custDB As Database
Dim qteTABLE As Recordset, custTABLE As Recordset, cabTABLE As Recordset

On Error GoTo ErrorHandler

Set myDB = Workspaces(0).OpenDatabase(QuoteDB, False, True)
Set custDB = Workspaces(0).OpenDatabase(CustomerDB, False, True)

'check if quote db contains any quotes - if not we need to disable modify/print
Set qteTABLE = myDB.OpenRecordset("SELECT * FROM [Quotes]")
If qteTABLE.BOF Then  'no records-disable
  Background!modqte.Enabled = False
  Background!vwpntqte.Enabled = False
  Background!remqte.Enabled = False
  Background!statchg.Enabled = False
Else
  Background!modqte.Enabled = True
  Background!vwpntqte.Enabled = True
  Background!remqte.Enabled = True
  Background!statchg.Enabled = True
End If
qteTABLE.Close
Set qteTABLE = Nothing 'new

'check if customer db contains any customers - if not we need to disable remove customers
Set custTABLE = custDB.OpenRecordset("SELECT * FROM [Customers]")
custTABLE.LockEdits = False
If custTABLE.BOF Then  'no records-disable
  Background!remcust.Enabled = False
  Background!editcust.Enabled = False
Else
  Background!remcust.Enabled = True
  Background!editcust.Enabled = True
End If
custTABLE.Close
Set custTABLE = Nothing 'new

'check if quote db contains any cable packages - if not we need to disable remove cable package
Set cabTABLE = myDB.OpenRecordset("SELECT * FROM [cablepkg]")
If cabTABLE.BOF Then  'no records-disable
  Background!remcab.Enabled = False
Else
  Background!remcab.Enabled = True
End If
cabTABLE.Close
Set cabTABLE = Nothing 'new

custDB.Close
myDB.Close
Set custDB = Nothing 'new
Set myDB = Nothing 'new
Exit Sub

ErrorHandler:
  Call displayERRORmessage("checkQUOTEdb subroutine")


End Sub




Public Sub setupQUOTE(ID As String, DimFlag As Integer, DescFlag As Integer, quoteSTYLE As Boolean)
'**************************************************************************
' This sub sets up report and opens it to screen.  It is called when a user
' creates/modifies or views a quote
'**************************************************************************
Dim quoteSTRING As String, attTITLE As String
'''Dim WordObj   'windows7
'''Set WordObj = CreateObject("Word.Application")  'tried windows7
quoteSTRING = "{Quotes.QuoteID} = " & Chr(34) & ID & Chr(34)
Background!Report1.SelectionFormula = quoteSTRING

Background!Report1.Formulas(0) = "DimDrawFlag=" & Str$(DimFlag)
Background!Report1.Formulas(3) = "DescripFlag=" & Str$(DescFlag)

attTITLE = "Attachment: "
'MsgBox QuoteFilePath & Right(ID, 8) & ".doc"
'appears to work perfectly in prelim testing.
Select Case quoteSTYLE
  Case True:  'want MS-WORD style
    Background!Report1.Destination = 2
    Background!Report1.PrintFileName = QuoteFilePath & Right(ID, 8) & ".doc"
    Background!Report1.PrintFileType = 17
    Background!Report1.Action = 1
    DoEvents
    'this is the part that opens Word
    Dim iret As Long
    iret = ShellExecute(0, "open", QuoteFilePath & Right(ID, 8) & ".doc", vbNullString, "price:\", SW_SHOWNORMAL)
    DoEvents
   '''Set WordObj = GetObject(QuoteFilePath & Right(ID, 8) & ".doc")  'tried windows8
   ''''WordObj.Parent.Visible = True  'windows8
  Case False:   'want Crystal Reports style
  Background!Report1.Destination = 0
    Background!Report1.PrintFileName = ""
    Background!Report1.PrintFileType = 0
    Background!Report1.WindowTitle = "Quote #: " & ID
    Background!Report1.Action = 1
 End Select

DoEvents

End Sub



Public Sub modifyMENU(menuSELECTED As Integer)
'**************************************************************************
' This sub sets the main menu on the MDI parent form when a menu item is
' selected.
'**************************************************************************
Dim exitITEMmsg As String
Screen.MousePointer = 11

Select Case menuSELECTED
  Case 1:
    exitITEMmsg = "Exit This Quote":
    Background!spacer2.Caption = Space(44)
    changeUNITSallowed = False
  Case 2:
    exitITEMmsg = "Exit Modifications"
    Background!spacer2.Caption = Space(70)
    changeUNITSallowed = False
  Case 3: exitITEMmsg = "Exit View/Print":  Background!spacer2.Caption = Space(45)
  Case 4: exitITEMmsg = "Exit Price Lookup": Background!spacer2.Caption = Space(40)
  Case 5: exitITEMmsg = "Exit Status Change": Background!spacer2.Caption = Space(39)
  Case 6: exitITEMmsg = "Exit Reports": Background!spacer2.Caption = Space(49)
  Case 7: exitITEMmsg = "Exit Database Maintenance": Background!spacer2.Caption = Space(25)
  Case 10: exitITEMmsg = "": Background!spacer2.Caption = Space(60)
End Select
Background!exitITEMmenu.Caption = exitITEMmsg
If menuSELECTED <> 10 And menuSELECTED <> 2 Then Background!exitITEMmenu.Visible = True
Background!exitPROGmenu.Visible = False
Background!Status.Visible = True
Background!qteMENU.Visible = False
Background!dbMENU.Visible = False
Background!reptMENU.Visible = False
Background!spacer2.Visible = True
End Sub

Public Sub exitITEM(whatTOask As Integer)
'***************************************************************************
' This sub is called any time a user exits, or in many cases, cancels a form
' It unloads open MDU child forms, clears up variables and restores main
' menu as needed
'***************************************************************************

Dim msg As String, title As String
Dim style As Integer, Response As Integer
Dim quoteIDtemp As String

Select Case whatTOask
  Case 1: msg = "Are you sure you want to exit this quote?"   ' Define message.
  Case 2: msg = "Are you sure you want to exit?  You will be returned to the main menu and all forms will be cleared. "   ' Define message.
  Case 3: msg = "Quote #" & QuoteIDhold & " will be removed from the database." & Chr(13) & Chr(13) & "Are you sure you want to delete this quote and return to the main menu?"
  Case 4:
    Select Case moreMODIFICATIONS
      Case False: msg = "Are you sure you want to exit the quote modifications?  Changes have not been saved to the database."
      Case True: msg = "Are you sure you want to exit the quote modifications?  Additional changes just made have not been saved to the database."
    End Select
 End Select

If whatTOask > 0 And whatTOask < 5 Then
  style = vbYesNo + vbCritical + vbDefaultButton2 ' Define buttons.
  title = "Exit?"  ' Define title.
  Response = MsgBox(msg, style, title)
End If

If Response = vbYes Or whatTOask = 0 Or whatTOask = 5 Then    ' User chose Yes.
  Screen.MousePointer = 11
  If whatTOask = 5 Then quoteIDtemp = QuoteIDhold
   Call clearDB
  Call clearQTE
  Call clearRPT   'clears all stored formulas for report
  Dim i As Integer
  Background.Show
  i = 1
  Do While i < Forms.Count
    ' Find first form besides "me" to unload
    If Forms(i).MDIChild And Forms(i).Name <> "Wallpaper" Then
      Unload Forms(i)
    Else
      i = i + 1
    End If
  Loop
  Background!Status.Caption = ""
  Background!exitITEMmenu.Visible = False
  Background!exitPROGmenu.Visible = True
  Background!dbMENU.Visible = True
  Background!qteMENU.Visible = True
  Call checkQUOTEdb
  Background!reptMENU.Visible = True
    Select Case metricDEFAULT
    Case True: Background!metORstd.Caption = "METRIC UNITS"
    Case False: Background!metORstd.Caption = "STANDARD UNITS"
  End Select
  Background!metORstd.Visible = True
  Background!spacer2.Visible = False
  changeUNITSallowed = True
  End If
  Screen.MousePointer = 1
  If whatTOask = 5 Then
    Call modifyMENU(2)
    modQTEflag = "Modify"
    qteID = quoteIDtemp
    UpQte1.Show
  End If
End Sub



Public Sub clearARRAYS()
'***************************************************************************
' This sub clears out arrays and variables when user goes back inputs.
' clearQTE is called when user exits quote.
'***************************************************************************

validREELSfound = False   'flag to check if any valid reels found
invalidCOUNT = 0  'counts number of invalid reels
recNUMBER = 0  'counts number of valid reels

Erase invalidREEL  'free memory used by invalid array
Erase validREEL
End Sub


Public Sub readREELsetupFILE()

Dim myDB As Database, myTABLE As Recordset
On Error GoTo ErrorHandler

'open tables which reads settings for overview form, quickstep
Set myDB = Workspaces(0).OpenDatabase(DataDB, False, True)
Set myTABLE = myDB.OpenRecordset("ReelConfig", dbOpenDynaset)
myTABLE.MoveFirst
showOVERVIEW = myTABLE!showOVERVIEW
QuickStepResp = myTABLE!quickstep
countSINCElastQTEDBbackup = myTABLE!reelBUcount
myTABLE.Close
myDB.Close
Set myTABLE = Nothing 'new
Set myDB = Nothing 'new

Call readGENERALsetupFILE
If QuoteLocationPath <> "" Then '6/12  user has a special location for quotes
  BackUpPath = QuoteLocationPath
  QuoteFilePath = QuoteLocationPath   '6/12  this is a user-specified location
End If
Exit Sub

ErrorHandler:
Call displayERRORmessage("subroutine readREELsetupFILE")

End Sub



Public Sub setLOCATIONS()
'**************************************************************************
'  This sub sets file, data, rept and bmp paths
'**************************************************************************
Const ssfPERSONAL = 46  'set directory to the common Documents folder
Dim strMyDocsPath As String  'sets MydocsPath

If UCase(App.Path) = "C:\GRPROGS" Then    'OLD LOCATION ON XP
  strMyDocsPath = "price:"             '
Else                                'WINDOWS 7/8 LOCATION IN PROGRAM FILES
  strMyDocsPath = CreateObject("Shell.Application").NameSpace(ssfPERSONAL).Self.Path
End If


If UCase(App.EXEName) = "REELPRG" Then  'running from VB environment
  DataPath = "price:\gleasprgvb6\quote\"  'Windows7
  QuotePath = "price:\gleasprgvb6\quote\"
  BmpPath = "price:\gleasprgvb6\reels\reelbmp\"
  BackUpPath = "price:\temp\"
  QuoteFilePath = "price:\gleasprgvb6\quote\quotes\"
Else  'actual .exe is running
  DataPath = App.Path & "\data\"  'Windows7
  BmpPath = App.Path & "\bmp\"

  'these files all point to the mydocuments on installed machine  'windows7
  QuotePath = strMyDocsPath & "\grprogs\data\"  'windows7 removed
  BackUpPath = strMyDocsPath & "\grprogs\backup\"
  QuoteFilePath = strMyDocsPath & "\grprogs\quotes\"  'this is the standard location
 End If

'Set DB locations
QuoteDBname = "reelqte"
DataDBname = "reeldata"

'these files will be located in mydocuments on installed machine windows7
QuoteDB = QuotePath & QuoteDBname & ".mdb"
CustomerDB = QuotePath & "customer.mdb"
RepDB = QuotePath & "repdata.mdb"

'these files will be in the installation directory
DataDB = DataPath & DataDBname & ".mdb"   'windows7
CableDB = DataPath & "cable.mdb"
'DataDB = QuotePath & DataDBname & ".mdb"  'windows7 removed
'CableDB = QuotePath & "cable.mdb" windows7 removed

programNAME = reel  'used to determine cable options


End Sub


Public Sub pullOUTbestREELS()
'***************************************************************************
' This sub pulls out the X reels which have the best price
' for each carrier.  validREEL(a).priceRANK will contain
' a "1" if it is the cheapest alternative and "2" if it is
' the second cheapest, and so on
'***************************************************************************
Dim a As Integer, i As Integer, b As Integer, j As Integer
Dim temp(1) As reelDATA
Dim tempLOC As Integer
Dim tempCARRIER As String, tempSERIES As String

'sort valid reels by price within the series/carrier
For a = 1 To recNUMBER
  For b = a + 1 To recNUMBER
    If validREEL(a).totalREELprice > validREEL(b).totalREELprice And validREEL(a).SERIES = validREEL(b).SERIES Then
      'swap
      temp(1) = validREEL(a)
      validREEL(a) = validREEL(b)
      validREEL(b) = temp(1)
      Erase temp
    End If
  Next b
Next a


'now assign a price rank to each reel within the series/carrier
tempCARRIER = ""
tempSERIES = ""
For a = 1 To recNUMBER
  If validREEL(a).SERIES <> tempSERIES Then
    tempSERIES = validREEL(a).SERIES
   i = 1
  End If
  If tempSERIES = "GRP" Or tempSERIES = "POWERTUBE" Then
    validREEL(a).PriceRank = 1
  Else
    validREEL(a).PriceRank = i
  End If
  i = i + 1
Next a

'this code will go through array of valid reels and sort it so all of those
'with a price ranking < number of reels user wants returned are moved to  the top of the array
i = 0
For a = 1 To recNUMBER
  If validREEL(a).PriceRank > 0 And validREEL(a).PriceRank <= numberMODELStoRETURN Then
    i = i + 1
    If a <> i Then
      'swap spots (pull those to top of array)
      temp(1) = validREEL(a)
      validREEL(a) = validREEL(i)
      validREEL(i) = temp(1)
      Erase temp
    End If
  End If
Next a

recNUMBER = i  'we have reduced the number of validreelS to i
'all of the reels are on top of array, redim to "erase" rest
ReDim Preserve validREEL(i) As reelDATA

'now they have been sorted, reset all location pointers to reflect new positions
For a = 1 To recNUMBER
  validREEL(a).locationPOINTER = a
Next a

End Sub

Public Sub getPRICEmultipliers(modelHOLD As String)
Dim myDB As Database
Dim myTABLE As Recordset
Dim tempMODEL As String

On Error GoTo ErrorHandler

If modelHOLD = "C" Then modelHOLD = "CM"
Set myDB = Workspaces(0).OpenDatabase(DataDB, False, True)
Set myTABLE = myDB.OpenRecordset("SELECT * from Pricefactors where [Item] = '" & modelHOLD & "'")
REELpriceMULTIPLIER = myTABLE!multiplier
myTABLE.Close
myDB.Close
Set myTABLE = Nothing 'new
Set myDB = Nothing 'new

Exit Sub

ErrorHandler:
Call displayERRORmessage("getPRICEmultipliers subroutine")


End Sub



'*************************************************
'  Ths sub updates databases to reflect changes made
' to their structure.  Used on DB's that cannot be overwritten
' when program sent out again
'*****************************************************
Public Sub updateDATABASES()
Dim myDB As Database, genDB
Dim MyTD As TableDef, cpTD As TableDef, genTD As TableDef
Dim CIField As Field, MEField As Field
Dim fieldNUMBER As Integer

On Error GoTo ErrorHandler
Set myDB = Workspaces(0).OpenDatabase(CustomerDB)
Set MyTD = myDB.TableDefs("StdDisc")

 'Create new Field object in Customer for discounts.
fieldNUMBER = 1

Set CIField = MyTD.CreateField("SreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("SreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("MMDreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("MMDreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("SMreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("SMreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("SHOreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("SHOreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("TMRreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("TMRreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("UEreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("UEreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("CMreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("CMreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("PreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("PreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("KreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("KreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("UHreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("UHreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("HMreelDisc1", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField

Set CIField = MyTD.CreateField("HMreelDisc2", dbInteger)
CIField.DefaultValue = 0
MyTD.Fields.Append CIField
myDB.Close
Set myDB = Nothing 'new

Exit Sub

ErrorHandler:
Select Case Err.Number
   Case 3191:
     Select Case fieldNUMBER
       Case 1, 2, 4, 5, 6:
         Err.Clear
         Resume Next
       Case 3:
         Err.Clear
         myDB.Close
         Set myDB = Nothing 'new
         Exit Sub
       'Case 4:
       '  genDB.Close
       '  Exit Sub
      End Select
   Case Else
  Call displayERRORmessage("UpdateDatabases")
End Select

End Sub

Public Sub checkPKGout()
'if user has changed width/radius, force to revisit mod2flag
qtyCONDUCTORSlessGRNDCHK = Val(Cable(1).COND) + Val(Cable(1).GROUND)


End Sub

Public Sub nextSTEPafterCUST(selCHOICE As String)
Select Case selCHOICE
  Case "SKIPPED":
    Select Case inputCOMPLETE
     Case False: CableDisplay.Show
     Case True: MainInp.Show
    End Select
  Case "CONTINUE":
    If custIDchecked <> CustIDhold And custIDchecked <> "" Then cabFLAG = False  'customer has changed, need new customer
    'check where to go from here
      Call checkFORexistingPKG
      If existingPKGS = True Then
      Select Case QuickStepResp
        Case True:
          Select Case inputCOMPLETE
            Case False: CablePkg.Show
            Case True: MainInp.Show
          End Select
        Case False: MainInp.Show
      End Select
    Else
      Select Case QuickStepResp
        Case True:
          Select Case inputCOMPLETE
            Case False: CableNew.Show
            Case True: MainInp.Show
          End Select
        Case False: MainInp.Show
      End Select
    End If
    Customer.Hide
  Case "CANCEL":
    MainInp.Show
End Select

End Sub



Public Sub removePRICINGfromDB()
Dim myDB As Database
Dim SQL As String
Set myDB = Workspaces(0).OpenDatabase(DataDB)

'if securityCODE = 5 then we will remove all pricing from the reelDATA database
SQL = "Update [CM] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [HM] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [K] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [P] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [SHO] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [TMR] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [U] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL
SQL = "Update [SSMMMD] SET [Cost] = 0 where [Cost] > 0"
myDB.Execute SQL

'take prices out of collector table
SQL = "Update [Collectr] SET [Sprc] = 0 where [Sprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [Smprc] = 0 where [Smprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [MMDprc] = 0 where [MMDprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [SHOprc] = 0 where [SHOprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [TMRprc] = 0 where [TMRprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [Uprc] = 0 where [Uprc] > 0"
myDB.Execute SQL
SQL = "Update [Collectr] SET [Penprc] = 0 where [Penprc] > 0"
myDB.Execute SQL

myDB.Close
Set myDB = Nothing 'new
End Sub

Public Sub clearSEARCHcriteria()
srchFRAME = ""
srchSPRING = ""
srchGEAR = ""
srchCOLL = ""
srchDRUMMIN = ""
srchDRUMMAX = ""
srchPREMIN = ""
srchPREMAX = ""
srchSPOOLMETHOD = ""
srchSPOOLWIDTH = ""
srchMOTOR = ""
srchSTYLE = ""
srchCOST = 0


End Sub

Public Sub calcTORQUE()
Dim tempTORQUEcalc As Single
'*********************************************************************
'* Calculates number of springs and available spring turns from used %
'*********************************************************************
If springSIZE >= 351 And springSIZE <= 354 Then numberOFspringsI = springSIZE - 350: springFAMILYindex = 1
If springSIZE >= 601 And springSIZE <= 604 Then numberOFspringsI = springSIZE - 600: springFAMILYindex = 2
If springSIZE >= 621 And springSIZE <= 624 Then numberOFspringsI = springSIZE - 620: springFAMILYindex = 3
If springSIZE >= 751 And springSIZE <= 754 Then numberOFspringsI = springSIZE - 750: springFAMILYindex = 4
If springSIZE >= 801 And springSIZE <= 804 Then numberOFspringsI = springSIZE - 800: springFAMILYindex = 5
If springSIZE >= 1001 And springSIZE <= 1008 Then numberOFspringsI = springSIZE - 1000: springFAMILYindex = 6

availSPRINGturns = maxSPRINGturns(springFAMILYindex) * (TURNSusedPERCENT / 100)
'Write #1, "availSPRINGturns: " & Str(availSPRINGturns)
numberOFspringsR = numberOFspringsI


'**********************************************************
'* Calculates torque based on spring torque curve
'**********************************************************
'calculate torque based on first part of spring torque curve
tempTORQUEcalc = slopeFIRSTpartOFcurve(springFAMILYindex) * availSPRINGturns + yinterceptFIRSTpartOFcurve(springFAMILYindex)
'Write #1, "Temp torque 1st: "; tempTORQUEcalc
'Write #1, "slopeFIRSTpartOFcurve: " & Str(slopeFIRSTpartOFcurve(springFAMILYindex))
'Write #1, "yinterceptFIRSTpartOFcurve: " & Str(yinterceptFIRSTpartOFcurve(springFAMILYindex))
'Write #1, "maxTURNSforFIRSTpartOFcurve: "; Str(maxTURNSforFIRSTpartOFcurve(springFAMILYindex))

If availSPRINGturns <= maxTURNSforFIRSTpartOFcurve(springFAMILYindex) Then GoTo LINE50

'calculate torque based on second part of spring torque curve
tempTORQUEcalc = slopeSECONDpartOFcurve(springFAMILYindex) * availSPRINGturns + yinterceptSECONDpartOFcurve(springFAMILYindex)
'Write #1, "Temp torque 2nd: "; tempTORQUEcalc
'Write #1, "slopeSECONDpartOFcurve: " & Str(slopeSECONDpartOFcurve(springFAMILYindex))
'Write #1, "yinterceptSECONDpartOFcurve: " & Str(yinterceptSECONDpartOFcurve(springFAMILYindex))
'Write #1, "maxTURNSforSECONDpartOFcurve: " & Str(maxTURNSforSECONDpartOFcurve(springFAMILYindex))

If availSPRINGturns <= maxTURNSforSECONDpartOFcurve(springFAMILYindex) Then GoTo LINE50

'calculate torque based on third part of spring torque curve
tempTORQUEcalc = slopeTHIRDpartOFcurve(springFAMILYindex) * availSPRINGturns + yinterceptTHIRDpartOFcurve(springFAMILYindex)
'Write #1, "Temp torque 3rd: "; tempTORQUEcalc
'Write #1, "slopeTHIRDpartOFcurve: " & Str(slopeTHIRDpartOFcurve(springFAMILYindex))
'Write #1, "yinterceptTHIRDpartOFcurve: " & Str(yinterceptTHIRDpartOFcurve(springFAMILYindex))
'Write #1, "maxTURNSforthirdpartOFcurve: " & Str(maxTURNSforTHIRDpartOFcurve(springFAMILYindex))

LINE50:
springTURNSavailFORreeling = availSPRINGturns * gearRATIO
'Write #1, "availSPRINGturns: " & Str(availSPRINGturns)
'Write #1, "gearRATIO: " & Str(gearRATIO)
'Write #1, "springTURNSavailFORreeling: " & Str(springTURNSavailFORreeling)
'MsgBox tempTORQUEcalc
'MsgBox numberOFspringsR
'MsgBox gearRATIO
springTORQUEavailFORreeling = tempTORQUEcalc * numberOFspringsR / gearRATIO
'Write #1, "springTORQUEavailFORreeling: " & Str(springTORQUEavailFORreeling)
'MsgBox springTORQUEavailFORreeling


'**********************************************************
'The following code calculates how much cable can be handled by
'the number available turns of a given spring configuration...
'**********************************************************

'Mark & John are thoroughly confused about this next line.....
springTURNSavailAFTERpretensionR = springTURNSavailFORreeling + 1! - (gearRATIO * pretensionTURNS)
'Write #1, "springTURNSavailAFTERpretensionR: " & Str(springTURNSavailAFTERpretensionR)
springTURNSavailAFTERpretensionI = Int(springTURNSavailAFTERpretensionR)
springTURNSavailAFTERpretensionR = springTURNSavailAFTERpretensionI
maxFULLLAYERSfromTURNSr = springTURNSavailAFTERpretensionR / maxWRAPSperLAYERr
maxFULLLAYERSfromTURNSi = Int(maxFULLLAYERSfromTURNSr)
maxFULLLAYERSfromTURNSr = maxFULLLAYERSfromTURNSi
extraWRAPSafterFULLLAYERSturnsr = springTURNSavailAFTERpretensionR - (maxWRAPSperLAYERr * maxFULLLAYERSfromTURNSr)
extraWRAPSafterFULLLAYERSturnsi = Int(extraWRAPSafterFULLLAYERSturnsr)  'for later display
turnsMAXIMUMcableLENGTH = ((drumSIZE + maxFULLLAYERSfromTURNSr * cableTHICK(1)) * pi / 12! * maxWRAPSperLAYERr * maxFULLLAYERSfromTURNSr) + ((drumSIZE + ((2! * maxFULLLAYERSfromTURNSr + 1!) * cableTHICK(1))) * pi / 12! * extraWRAPSafterFULLLAYERSturnsr)
'Write #1, "turnsMAXIMUMcableLENGTH: "; Str(turnsMAXIMUMcableLENGTH)
turnsACTIVEcableLENGTH = turnsMAXIMUMcableLENGTH - deadWRAPlength
'Write #1, "turnsMAXIMUMcableLENGTH: "; Str(turnsMAXIMUMcableLENGTH)

'***********************************************************************
'* Calculates new torque curve based on gear ratio and number of springs
'***********************************************************************

ADJmaxTURNSforFIRSTpartOFcurve = maxTURNSforFIRSTpartOFcurve(springFAMILYindex) * gearRATIO
ADJslopeFIRSTpartOFcurve = slopeFIRSTpartOFcurve(springFAMILYindex) * numberOFspringsR / (gearRATIO * gearRATIO)
ADJyinterceptFIRSTpartOFcurve = yinterceptFIRSTpartOFcurve(springFAMILYindex) * numberOFspringsR / gearRATIO

ADJmaxTURNSforSECONDpartOFcurve = maxTURNSforSECONDpartOFcurve(springFAMILYindex) * gearRATIO
ADJslopeSECONDpartOFcurve = slopeSECONDpartOFcurve(springFAMILYindex) * numberOFspringsR / (gearRATIO * gearRATIO)
ADJyinterceptSECONDpartOFcurve = yinterceptSECONDpartOFcurve(springFAMILYindex) * numberOFspringsR / gearRATIO

ADJmaxTURNSforTHIRDpartOFcurve = maxTURNSforTHIRDpartOFcurve(springFAMILYindex) * gearRATIO
ADJslopeTHIRDpartOFcurve = slopeTHIRDpartOFcurve(springFAMILYindex) * numberOFspringsR / (gearRATIO * gearRATIO)
ADJyinterceptTHIRDpartOFcurve = yinterceptTHIRDpartOFcurve(springFAMILYindex) * numberOFspringsR / gearRATIO

adjustedTORQUE = springTORQUEavailFORreeling
'Write #1, "adjustedTORQUE #1: "; Str(adjustedTORQUE)
'Write #1, "compartmentACTIVEcableLENGTH: "; Str(compartmentACTIVEcableLENGTH)
'Write #1, "turnsACTIVEcableLENGTH: "; Str(turnsACTIVEcableLENGTH)

If compartmentACTIVEcableLENGTH < turnsACTIVEcableLENGTH Then
  tempTURNS = (gearRATIO * pretensionTURNS) + maxUSABLEwrapsR - 1
 'write #1, "gearRATIO: "; Str(gearRATIO)
 'write #1, "pretensionTURNS: "; Str(pretensionTURNS)
 'write #1, "maxUSABLEwrapsR: "; Str(maxUSABLEwrapsR)
  adjustedTORQUE = ADJslopeFIRSTpartOFcurve * tempTURNS + ADJyinterceptFIRSTpartOFcurve
 'write #1, "ADJslopeFIRSTpartOFcurve: "; Str(ADJslopeFIRSTpartOFcurve)
 'write #1, "tempTURNS: "; Str(tempTURNS)
 'write #1, "ADJyinterceptFIRSTpartOFcurve: "; Str(ADJyinterceptFIRSTpartOFcurve)
 'write #1, "adjustedTORQUE #2: "; Str(adjustedTORQUE)
  If tempTURNS > ADJmaxTURNSforFIRSTpartOFcurve Then
    adjustedTORQUE = ADJslopeSECONDpartOFcurve * tempTURNS + ADJyinterceptSECONDpartOFcurve
   'write #1, "adjustedTORQUE #3: "; Str(adjustedTORQUE)
    If tempTURNS > ADJmaxTURNSforSECONDpartOFcurve Then
      adjustedTORQUE = ADJslopeTHIRDpartOFcurve * tempTURNS + ADJyinterceptTHIRDpartOFcurve
     'write #1, "adjustedTORQUE #4: "; Str(adjustedTORQUE)
    End If
  End If
End If


End Sub

Public Sub calcINERTIA()
'Note: this sub is not called for CM or HM reels

Dim diskINERTIA As Single
Dim wrapperINERTIA As Single
Dim shaftINERTIA As Single
Dim spokeINERTIA As Single
Dim rimINERTIA As Single
Dim flangeINERTIA As Single
Dim reinforceINERTIA As Single
Dim spokeWEIGHTperINCH As Single
Dim rimWEIGHTperINCH As Single
Dim rimHEIGHT As Single
Dim spokeWEIGHT As Single
Dim rimWEIGHT As Single

Select Case srchSTYLE
  Case "S", "SM", "MMD"
'************************************************************************
'The following code calculates disc, wrapper and reel inertia where:
'DISC INERTIA..... SOLID CYLINDER             Idisk=0.5*W*R^2
'WRAPPER INERTIA.. THIN WALL HOLLOW CYLINDER  Iwrapper=W*R^2
'SHAFT INERTIA.... = .1
'************************************************************************

' 2.0 * PI * 5.133 = 32.2516
  Select Case frameSIZE
  Case 14: diskINERTIA = 1.82: wrapperINERTIA = 0.41 * (drumSIZE / 24!) ^ 2! * 4!
  Case 16: diskINERTIA = 3.09: wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 4!
  Case 18: diskINERTIA = 4.98
    If drumSIZE <= 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 4!
    If drumSIZE > 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 8!
  Case 21: diskINERTIA = 9.19
    If drumSIZE <= 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 4!
    If drumSIZE > 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 8!
  Case 24: diskINERTIA = 15.75
    If drumSIZE <= 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 4!
    If drumSIZE > 14! Then wrapperINERTIA = 0.5 * (drumSIZE / 24!) ^ 2! * 8!
  Case 28: diskINERTIA = 29.13
    If drumSIZE <= 14! Then wrapperINERTIA = 0.67 * (drumSIZE / 24!) ^ 2! * 4!
    If drumSIZE > 14! Then wrapperINERTIA = 0.67 * (drumSIZE / 24!) ^ 2! * 8!
  Case 32: diskINERTIA = 49.6
    If drumSIZE <= 14! Then wrapperINERTIA = 0.67 * (drumSIZE / 24!) ^ 2! * 4!
    If drumSIZE > 14! Then wrapperINERTIA = 0.67 * (drumSIZE / 24!) ^ 2! * 8!
End Select

shaftINERTIA = 0.1
reelINERTIA = diskINERTIA + wrapperINERTIA + shaftINERTIA
''write #1, "Reel inertia: " & Str(reelINERTIA)

  Case "SHO", "TMR":

  '************************************************************************
'The following code calculates shaft, flange and wrapper inertia
'************************************************************************
' SHAFT INERTIA:
'
' SHAFT WEIGHT = PI * (OUTER RADIUS SQUARED - INNER RADIUS SQUARED) * LENGTH * WEIGHT PER CUB. IN
' WHERE:
'      OUTER DIAMETER = 1.998"   INNER DIAMETER = 1.500"
'      LENGTH = 19.68"           WEIGHT PER CU. IN OF STEEL = .283 #
'      SHAFT WEIGHT = 7.62 #
'
' SHAFT INERTIA (ANNULAR CYLINDER): .5 * WEIGHT * (INNER RADIUS SQUARED + OUTER RADIUS SQUARED)
' shaftINERTIA= 5.95
'***********************************************************************
shaftINERTIA = 5.95
shaftweight = 7.62

'************************************************************************
' SPOOL FLANGE INERTIA:
'
' FLANGE WEIGHT = AREA * THICKNESS * WEIGHT PER CUBIC INCH
' WHERE:
'     AREA = PI * RADIUS SQUARED
'     RADIUS = 8 INCHES        THICKNESS = .5"
'     WEIGHT PER CUBIC INCH = .283
' FLANGE WEIGHT = 28.45#
'
' FLANGE INERTIA (SOLID CYLINDER):  .5 * WEIGHT * RADIUS SQUARED
' flangeINERTIA= 910.4
'***********************************************************************

flangeINERTIA = 910.4
flangeweight = 28.45

'************************************************************************
' WRAPPER INERTIA:
'
' WRAPPER WEIGHT = CIRCUMFERENCE * WIDTH * THICKNESS * WEIGHT PER CUBIC INCH
' WHERE:
'     CIRCUMFERENCE = 2 * PI * WRAPPER RADIUS
'     THICKNESS FOR 11 GAUGE STEEL = .1196
'     WEIGHT PER CUBIC INCH = .283
'
' WRAPPER INERTIA (THIN WALLED HOLLOW CYLINDER):
'     WEIGHT * WRAPPER RADIUS SQUARED
'
'***********************************************************************

wrapperweight = 2! * pi * (drumSIZE / 2!) * wrapperWIDTHr * 0.1196 * 0.283
wrapperINERTIA = wrapperweight * (drumSIZE / 2!) ^ 2


If srchSPOOLMETHOD = "R" And frameSIZE = 54 Then GoTo 257
If srchSPOOLMETHOD = "M" Then GoTo 257


'************************************************************************
' FOR SPOOLS OF DISC CONSTRUCTION:
'************************************************************************
' DISC INERTIA:
'
' DISC WEIGHT = AREA * THICKNESS * WEIGHT PER CUBIC INCH
' WHERE:
'     AREA = PI * (OUTER RADIUS SQUARED - INNER RADIUS SQUARED)
'     OUTER DIAMETER = SPOOL DIAMETER
'     INNER DIAMETER = 12"
'     THICKNESS FOR 11 GAUGE STEEL = .1196"
'     WEIGHT PER CUBIC INCH = .283#
'
' DISC INERTIA (ANNULAR CYLINDER): .5 * WEIGHT * (INNER RADIUS SQUARED + OUTER RADIUS SQUARED)
'
'***********************************************************************

diskweight = pi * ((frameSIZE / 2!) ^ 2 - (12! / 2!) ^ 2) * 0.1196 * 0.283
diskINERTIA = 2! * 0.5 * diskweight * ((frameSIZE / 2!) ^ 2 + (12! / 2!) ^ 2)

'************************************************************************
' DISC REINFORCEMENT INERTIA:
'
' DISC REINFORCEMENT WEIGHT = CIRCUMFERENCE * WEIGHT PER FOOT
' WHERE:
'     CIRCUMFERENCE = 2 * PI * RADIUS
'     RADIUS = SPOOL DIAMETER/2
'     WEIGHT PER FOOT FOR SCHEDULE 40 PIPE = .85 #/FT = .07 #/IN
'
' DISC REINFORCEMENT INERTIA (THIN WALLED HOLLOW CYLINDER):
'     2 DISCS * WEIGHT * INNER RADIUS SQUARED
'
'***********************************************************************

reinforceweight = 2! * pi * (frameSIZE / 2!) * 0.07
reinforceINERTIA = 2! * (reinforceweight * (frameSIZE / 2!) ^ 2)



totalWEIGHTlessCABLE = shaftweight + flangeweight + 2! * diskweight + 2! * reinforceweight + wrapperweight
totalINERTIA = diskINERTIA + wrapperINERTIA + shaftINERTIA + flangeINERTIA + reinforceINERTIA
reelINERTIA = totalINERTIA / 144
''write #1, "Reel inertia: " & Str(reelINERTIA)

Exit Sub

257:
'************************************************************************
' FOR SPOOLS OF SPOKE CONSTRUCTION:
'*************************************************************************

spokeWEIGHTperINCH = 0.12
rimWEIGHTperINCH = 0.12
rimHEIGHT = 1!

'************************************************************************
' SPOKE INERTIA:
'
' SPOKES ARE MADE OF 1" SQUARE TUBE
'
' WEIGHT OF SPOKE = LENGTH * SPOKE WEIGHT PER INCH
'
' WHERE:
'     LENGTH = SPOOL DIAMETER - 2 * RIM HEIGHT
'     RIM HEIGHT = 1"
'     SPOKE WEIGHT PER INCH = .12 #/IN
'
' SPOKE INERTIA (SLENDER ROD, AXIS THROUGH ONE END):
' 2 SIDES * 4 SPOKES/SIDE * .083 * SPOKE WEIGHT * SPOKE LENGTH SQUARED
'
'***********************************************************************

spokeWEIGHT = (frameSIZE - 2! * rimHEIGHT) * spokeWEIGHTperINCH
spokeINERTIA = 2! * 4! * 0.083 * spokeWEIGHT * (frameSIZE - 2! * rimHEIGHT) ^ 2

'************************************************************************
' RIM INERTIA:
'
' RIMS ARE MADE OF 1" SQUARE TUBE
' WEIGHT OF RIM = CIRCUMFERENCE * RIM WEIGHT PER INCH
' WHERE:
'     CIRCUMFERENCE = 2 * PI * RIM RADIUS
'     RIM WEIGHT PER INCH = .12 #/IN
'
' RIM INERTIA (THIN HOLLOW CYLINDER):
' 2 SIDES * RIM WEIGHT * RIM RADIUS SQUARED
'
'***********************************************************************

rimWEIGHT = 2! * pi * (frameSIZE / 2! - rimHEIGHT) * rimWEIGHTperINCH
rimINERTIA = 2! * rimWEIGHT * (frameSIZE / 2! - rimHEIGHT) ^ 2

totalWEIGHTlessCABLE = shaftweight + flangeweight + 8! * spokeWEIGHT + 2! * rimWEIGHT + wrapperweight
totalINERTIA = spokeINERTIA + wrapperINERTIA + shaftINERTIA + flangeINERTIA + rimINERTIA

reelINERTIA = totalINERTIA / 144
''write #1, "Reel inertia: " & Str(reelINERTIA)
Case "U":
' per BRAD: use same disc and shaft inertias as S-Reel program
' wrapper inertias are provided by Brad
'************************************************************************
wrapperINERTIA = ((reelWIDTH / 12) * 1.478) * ((drumSIZE / 24!) ^ 2!)

Select Case drumSIZE
  Case Is < 14: wrapperINERTIA = wrapperINERTIA * 4    '4 sections
  Case Is < 20: wrapperINERTIA = wrapperINERTIA * 8    '8 sections
  Case Else: wrapperINERTIA = wrapperINERTIA * 12    '12 sections
End Select

Select Case frameSIZE
  Case 14: diskINERTIA = 1.82
  Case 16: diskINERTIA = 3.09
  Case 18: diskINERTIA = 4.98
  Case 21: diskINERTIA = 9.19
  Case 24: diskINERTIA = 15.75
  Case 28: diskINERTIA = 29.13
  Case 32: diskINERTIA = 49.6
End Select

shaftINERTIA = 0.1
reelINERTIA = diskINERTIA + wrapperINERTIA + shaftINERTIA
''write #1, "Reel inertia: " & Str(reelINERTIA)

Case "K":
  Select Case frameSIZE
    Case 14: diskINERTIA = 1.82
    Case 16: diskINERTIA = 3.09
    Case 18: diskINERTIA = 4.98
    Case 21: diskINERTIA = 9.19
    Case 24: diskINERTIA = 15.75
    Case 28: diskINERTIA = 29.13
    Case 32: diskINERTIA = 49.6
  End Select

  Select Case hoseIDcode
    Case "4": wrapperINERTIA = 0.06
    Case "6": wrapperINERTIA = 0.09
    Case "8": wrapperINERTIA = 0.11
    Case "12": wrapperINERTIA = 0.58
  End Select
  shaftINERTIA = 0.1
  reelINERTIA = diskINERTIA + wrapperINERTIA + shaftINERTIA
End Select


End Sub

Public Sub getCMspringDATA(availableTURNS As Integer)
'***************************************************************************
' This sub looks into reeldata database to get spring torque data
'***************************************************************************
Dim reelDB As Database
Dim reelRS As Recordset
Dim SQL As String

On Error GoTo ErrorHandler

Set reelDB = DBEngine.Workspaces(0).OpenDatabase(DataDB, False, True)
SQL = "SELECT * from cmspring WHERE [turncount] = " & Str(availableTURNS)

Set reelRS = reelDB.OpenRecordset(SQL)
If reelRS.RecordCount <> 0 Then
  Select Case srchSPRING
    Case "A", "1": springTORQUEavailFORreeling = reelRS!a
    Case "B", "2": springTORQUEavailFORreeling = reelRS!b
    Case "C", "3": springTORQUEavailFORreeling = reelRS!price
    Case "D", "4": springTORQUEavailFORreeling = reelRS!d
    Case "E", "5": springTORQUEavailFORreeling = reelRS!e
    Case "G", "7": springTORQUEavailFORreeling = reelRS!g
    Case "H", "8": springTORQUEavailFORreeling = reelRS!H
    Case "J", "10": springTORQUEavailFORreeling = reelRS!j
    Case "K", "11": springTORQUEavailFORreeling = reelRS!k
    Case "U": springTORQUEavailFORreeling = reelRS!u
    Case "V": springTORQUEavailFORreeling = reelRS!v
  End Select
End If

reelRS.Close
reelDB.Close
Set reelRS = Nothing 'new
Set reelDB = Nothing 'new


Exit Sub
ErrorHandler:
Call displayERRORmessage("getCMspringDATA subroutine")
End Sub

Public Sub doINITIALCMcalcs()
Dim a As Integer
Dim fileSTR As String
Dim conductorQTY As Integer
Dim IEC As Integer
Dim IREM As Integer
Dim IQUOT As Integer
Dim IXCORR As Integer
Dim IXST As Integer
Dim IXFIN As Integer
Dim ITMAX As Integer
Dim ITEMP As Integer
Dim ITEMPB As Integer
Dim testCALC As Double

Dim Index As Integer
Dim XACT As Integer
Dim YIND As Integer

Dim IYFIN As Integer
Dim CIRC As Single


Dim CLRMIN As Single

Dim RATIO As Single
Dim RLEN As Single
Dim WRAPEC As Single
Dim ROWEC As Single
Dim ET As Single


validCOMPARTMENT = False
validTURNS = False

If CableCF = 0 Then
  cableCLEARANCEfactor = 1
Else
  cableCLEARANCEfactor = CableCF
End If

gearRATIO = 1!

Select Case srchFRAME
  Case "14":
    frameSIZE = 13.75
    drumSIZE = 7
    wrapperWIDTHr = 3
    spoolWEIGHT = 27.3
    coefficient = 0.16
  Case "16":
    frameSIZE = 15.75
    drumSIZE = 7
    wrapperWIDTHr = 3.5
    spoolWEIGHT = 52.8
    coefficient = 0.16
  Case "19":
    frameSIZE = 19!
    drumSIZE = 10.5
    wrapperWIDTHr = 4
    spoolWEIGHT = 59.6
    coefficient = 0.025
End Select
'fileSTR = srchSTYLE & srchFRAME & "-" & srchCOLL & "-" & srchSPRING & "11" & "0" & Trim(Str(pretensionTURNS))
'fileSTR = fileSTR & "  Frame SIZE: " & Str(frameSIZE)
'fileSTR = fileSTR & "  Drum SIZE: " & Str(drumSIZE)
''write #1, fileSTR

maxWRAPSperLAYERr = wrapperWIDTHr / cableTHICK(1)
''write #1, "maxWRAPSperLAYERr: " & Str(maxWRAPSperLAYERr)
''write #1, "wrapperWIDTHr: " & Str(wrapperWIDTHr)
''write #1, "cableTHICK(1): " & Str(cableTHICK(1))
maxWRAPSperLAYERi = Int(maxWRAPSperLAYERr)
''write #1, "maxWRAPSperLAYERi: " & Str(maxWRAPSperLAYERi)
maxWRAPSperLAYERr = maxWRAPSperLAYERi
''write #1, "maxWRAPSperLAYERi: " & Str(maxWRAPSperLAYERi)

maxCABLElayersR = (frameSIZE - drumSIZE) / (2! * cableTHICK(1))
''write #1, "maxCABLElayersR: " & Str(maxCABLElayersR)
''write #1, "frameSIZE: " & Str(frameSIZE)
''write #1, "drumSIZE: " & Str(drumSIZE)
maxCABLElayersI = Int(maxCABLElayersR)
''write #1, "maxCABLElayersI: " & Str(maxCABLElayersI)

maxUSABLElayersR = maxCABLElayersR - cableCLEARANCEfactor
''write #1, "maxUSABLElayersR: " & Str(maxUSABLElayersR)
''write #1, "cableCLEARANCEfactor: " & Str(cableCLEARANCEfactor)
maxUSABLElayersI = Int(maxUSABLElayersR)
maxUSABLElayersR = maxUSABLElayersI

CLRMIN = ((frameSIZE - drumSIZE) / 2!) - (maxCABLElayersI * cableTHICK(1))
EC = maxWRAPSperLAYERr * (CLRMIN / cableTHICK(1))
If cableTHICK(1) > 1 Then EC = 0
IEC = Int(EC)
EC = IEC

''write #1, "EC: " & Str(EC)

'**********************************************************
'* Calculates cable that can be physically placed in compartment
'**********************************************************
compartmentHEIGHT = (frameSIZE - drumSIZE) / 2!

For a = 1 To 50
  IXARR(a) = maxWRAPSperLAYERi
  WRAP(a) = 0
  Row(a) = 0
Next a

IXARR(1) = IXARR(1) - deadWRAPS

RATIO = (wrapperWIDTHr - maxWRAPSperLAYERr * cableTHICK(1)) / cableTHICK(1)
''write #1, "ratio: " & Str(RATIO)
If RATIO < 0.52 Then GoTo line350
If RATIO >= 0.52 And RATIO < 0.64 Then Index = 1
If RATIO >= 0.64 And RATIO < 0.76 Then Index = 2
If RATIO >= 0.76 And RATIO < 0.88 Then Index = 3
If RATIO >= 0.88 Then Index = 4

IQUOT = Int(maxUSABLElayersI / 5)
''write #1, "IQUOT: " & Str(IQUOT)
IREM = maxUSABLElayersI - IQUOT * 5
If IREM <= 1 Then IREM = 1
''write #1, "IREM: " & Str(IREM)

IXCORR = JXCORR(IREM, Index) + IQUOT * JXCORR(5, Index)
''write #1, "IXCORR: " & Str(IXCORR)
IXST = maxUSABLElayersI / 2 - IXCORR / 2 + 1
If IXST < 1 Then IXST = 1
''write #1, "IXST: " & Str(IXST)
IXFIN = IXST + IXCORR - 1
If cableTHICK(1) > 1 Then GoTo line350

For a = IXST To IXFIN
  IXARR(a) = IXARR(a) + 1
Next a

line350:
ITMAX = 0
RLEN = 0
For a = 1 To 50
  XACT = IXARR(a)
  YIND = a
  WRAP(a) = (drumSIZE + (2! * YIND - 1) * cableTHICK(1)) * pi / 12
  Row(a) = XACT * WRAP(a)
  ''write #1, Str(a) & ": " & "XACT: " & Str(XACT) & "  wrap(a): " & Str(WRAP(a)) & "  row(a): " & Str(Row(a))
Next a
  ''write #1, "maxUSABLElayersI: " & Str(maxUSABLElayersI)
For a = 1 To maxUSABLElayersI
  ITMAX = ITMAX + IXARR(a)
  RLEN = RLEN + Row(a)
Next a

line400:
If cableCLEARANCEfactor >= 1 Then GoTo line410
a = maxUSABLElayersI + 1
ITMAX = ITMAX + IXARR(a)
RLEN = RLEN + Row(a)
GoTo line415

line410:
a = maxUSABLElayersI + 1
YIND = a
WRAPEC = (drumSIZE + (2! * YIND - 1!) * cableTHICK(1)) * pi / 12
''write #1, "WRAPEC: " & Str(WRAPEC)
ROWEC = EC * WRAPEC
''write #1, "ROWEC: " & Str(ROWEC)
ITMAX = ITMAX + EC
''write #1, "ITMAX: " & Str(ITMAX)
RLEN = RLEN + ROWEC



line415:
If EC > 0 Or cableCLEARANCEfactor >= 1 Then maxUSABLElayersR = maxUSABLElayersR + 1
maxUSABLElayersI = maxUSABLElayersR

compartmentACTIVEcableLENGTH = RLEN
maxUSABLEwrapsR = ITMAX
''write #1, "maxUSABLEwrapsR: " & Str(maxUSABLEwrapsR)
''write #1, "compartmentACTIVEcableLENGTH: " & Str(compartmentACTIVEcableLENGTH)

If compartmentACTIVEcableLENGTH < travelINft Then
  Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(1)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
End If
If compartmentACTIVEcableLENGTH < travelINft Then invalidWARNING = True
validCOMPARTMENT = True

'**********************************************************
'The following code calculates how much cable can be handled by
'the number available turns of a given spring configuration...
'**********************************************************
springTURNSavailFORreeling = Int(Val(maxTURNSfromSPRING)) * (TURNSusedPERCENT / 100) 'SS  seems that turnsused is already part of calc in calcAVAILCMturns sub
springTURNSavailAFTERpretensionR = springTURNSavailFORreeling - pretensionTURNS
springTURNSavailAFTERpretensionI = Int(springTURNSavailAFTERpretensionR)
springTURNSavailAFTERpretensionR = springTURNSavailAFTERpretensionI

ITEMP = springTURNSavailAFTERpretensionI
turnsMAXIMUMcableLENGTH = 0
For a = 1 To 50
  IYFIN = a
  If ITEMP < IXARR(a) Then GoTo line422
  ITEMP = ITEMP - IXARR(a)
  turnsMAXIMUMcableLENGTH = turnsMAXIMUMcableLENGTH + Row(a)
Next a

line422:
a = IYFIN
ET = ITEMP
turnsMAXIMUMcableLENGTH = turnsMAXIMUMcableLENGTH + ET * WRAP(a)
turnsACTIVEcableLENGTH = turnsMAXIMUMcableLENGTH
maxFULLLAYERSfromTURNSr = IYFIN
If ET = 0 Then maxFULLLAYERSfromTURNSr = IYFIN - 1
''write #1, "turnsACTIVEcableLENGTH: " & Str(turnsACTIVEcableLENGTH)
If turnsACTIVEcableLENGTH < travelINft Then
  Select Case specificINPUT(modelINDEX)
         Case False
           Call invalidSTORE(2)
           Exit Sub
         Case True
           invalidWARNING = True
        End Select
End If
If turnsACTIVEcableLENGTH < travelINft Then invalidWARNING = True
'**********************************************************
'The following code calculates the collector friction (ft/lbs)
'**********************************************************
Select Case cableORhose
  Case "HD", "HS":  'hoses
    'although it says  "collector" fricton, it's actually swivel friction
    Select Case hoseIDcode  'from super-swivel chart of rotating torque vs. pressure
      Case "4": torqueTOovercomeCOLLECTORfriction = 2.5 / 12  'inch pounds/12" to get foot pounds
      Case "6": torqueTOovercomeCOLLECTORfriction = 5 / 12
      Case "8": torqueTOovercomeCOLLECTORfriction = 7.5 / 12
      Case "12": torqueTOovercomeCOLLECTORfriction = 12.5 / 12
      Case "16": torqueTOovercomeCOLLECTORfriction = 20 / 12
      Case "20": torqueTOovercomeCOLLECTORfriction = 50 / 12
      Case "24": torqueTOovercomeCOLLECTORfriction = 56 / 12
    End Select
  Case Else
    Select Case Left$(srchCOLL, 1)
     Case "Z", "A", "B", "C", "D":
       Select Case Val(Right$(srchCOLL, 2))
         Case Is < 5: torqueTOovercomeCOLLECTORfriction = 0.42
         Case Is < 9: torqueTOovercomeCOLLECTORfriction = 0.67
         Case Is >= 9: torqueTOovercomeCOLLECTORfriction = 0.83
       End Select
     Case "E", "F": torqueTOovercomeCOLLECTORfriction = 0.67
     Case "G", "H": torqueTOovercomeCOLLECTORfriction = 0.9
    End Select
End Select


'************************************************************************
'The following code calculates wrapper INERTIA:
'************************************************************************

Select Case srchFRAME
  Case "14": reelINERTIA = 3.2
  Case "16": reelINERTIA = 10.9
  Case "19": reelINERTIA = 13.64
End Select


'****************************************************************************
' The following code assigns a torque safety factor based on cable diameter
'****************************************************************************
Select Case srchSTYLE
  Case "HM":
    Select Case cableTHICK(1)
      Case Is <= 0.5: torqueSAFETYfactor = 1.2
      Case Is <= 0.75
        If drumSIZE <= 9! Then torqueSAFETYfactor = 1.3
        If drumSIZE > 9! Then torqueSAFETYfactor = 1.2
      Case Is <= 1!
        If drumSIZE <= 12! Then torqueSAFETYfactor = 1.4
        If drumSIZE > 12! Then torqueSAFETYfactor = 1.3
      Case Is <= 1.25
        If drumSIZE <= 15! Then torqueSAFETYfactor = 1.5
        If drumSIZE > 15! Then torqueSAFETYfactor = 1.4
      Case Is <= 1.5
        If drumSIZE <= 18! Then torqueSAFETYfactor = 1.6
        If drumSIZE > 18! Then torqueSAFETYfactor = 1.5
      Case Else
        If drumSIZE <= 21! Then torqueSAFETYfactor = 1.7
        If drumSIZE > 21! Then torqueSAFETYfactor = 1.6
    End Select
  Case Else
    Select Case metricDEFAULT
      Case True:
        Select Case Val(Cable(1).AWG)
          Case Is < 0.9: CIRC = 1620  '18 AWG equiv
          Case Is < 1.5: CIRC = 2580 '16 AWG equiv
          Case Is < 2.5: CIRC = 4110 '14 AWG equiv
          Case Is < 3.5: CIRC = 6530 '12 AWG equiv
          Case Is < 5.5: CIRC = 10400 '10 AWG equiv
          Case Is < 9#:   CIRC = 16500 '8 AWG equiv
          Case Else:  CIRC = 26300 '6 AWG equiv
        End Select
      Case False:
        Select Case Trim(Cable(1).AWG)
          Case "18": CIRC = 1620
          Case "16": CIRC = 2580
          Case "14": CIRC = 4110
          Case "12": CIRC = 6530
          Case "10": CIRC = 10400
          Case "8":  CIRC = 16500
          Case "6":  CIRC = 26300
        End Select
    End Select
    conductorQTY = qtyCONDUCTORSlessGRNDCHK + Val(Cable(1).GRNDCHCK)
    If Cable(1).style = "C" Or Cable(1).style = "G" Then conductorQTY = conductorQTY + 1
    testCALC = (conductorQTY * CIRC)
    Select Case testCALC
      Case Is <= 10000: torqueSAFETYfactor = 0.25
      Case Is <= 15000: torqueSAFETYfactor = 0.5
      Case Is <= 20000: torqueSAFETYfactor = 0.75
      Case Is <= 30000: torqueSAFETYfactor = 1
      Case Is <= 45000: torqueSAFETYfactor = 1.25
      Case Is <= 60000: torqueSAFETYfactor = 1.5
      Case Is <= 75000: torqueSAFETYfactor = 1.75
      Case Is <= 90000: torqueSAFETYfactor = 2!
      Case Else: torqueSAFETYfactor = 2.5
    End Select
  End Select


CBEND = 2! * torqueSAFETYfactor * drumSIZE / 24!
RA = drumSIZE / 24
momentARM = (drumSIZE + 5! * cableTHICK(1)) / (2! * 12!)


'***********************************************************************
'* Calculates torque available from spring
'***********************************************************************

Call getCMspringDATA(Int(springTURNSavailFORreeling))


If compartmentACTIVEcableLENGTH < turnsACTIVEcableLENGTH Then
  tempTURNS = (gearRATIO * pretensionTURNS) + maxUSABLEwrapsR
  Call getCMspringDATA(Int(tempTURNS))
End If

adjustedTORQUE = springTORQUEavailFORreeling
validTURNS = True
'MsgBox "through initial calcs"
''write #1, "Finished with init calcs"

End Sub

Public Function JXCORR(a As Integer, b As Integer)
Select Case a
    Case 1:
      Select Case b
        Case 1: JXCORR = 0
        Case 2: JXCORR = 0
        Case 3: JXCORR = 0
        Case 4: JXCORR = 0
      End Select
    Case 2:
      Select Case b
        Case 1: JXCORR = 0
        Case 2: JXCORR = 0
        Case 3: JXCORR = 1
        Case 4: JXCORR = 1
      End Select
    Case 3:
      Select Case b
        Case 1: JXCORR = 0
        Case 2: JXCORR = 1
        Case 3: JXCORR = 1
        Case 4: JXCORR = 2
      End Select
    Case 4:
      Select Case b
        Case 1: JXCORR = 0
        Case 2: JXCORR = 1
        Case 3: JXCORR = 2
        Case 4: JXCORR = 3
      End Select
    Case 5:
      Select Case b
        Case 1: JXCORR = 1
        Case 2: JXCORR = 2
        Case 3: JXCORR = 3
        Case 4: JXCORR = 4
      End Select
  End Select

End Function



Public Sub calcLIFTapplCM()
Dim Tcabel As Single
Dim TBRGEL As Single
Dim TSPLEL As Single
Dim VLIFT As Single
Dim RLMAX As Single
Dim EL As Single
Dim TSPLFL As Single
Dim TEMPB As Single
Dim TCABFL As Single
Dim TPENFL As Single
Dim TBGRFL As Single
Dim IYIND As Integer
Dim IYFIN As Integer
Dim ITEMPB As Integer
Dim TBRGFL As Single

Dim torqueMAXIMUMliftLENGTH As Single
Dim maxFULLLAYERSfromTORQUEliftR As Single
Dim TEMPcircumferenceTOTAL As Single
Dim circumferenceATcenterOFmaxFULLlayerLIFT As Single
Dim pendantTORQUEftlb As Single
Dim liftTORQUEftlb As Single
Dim torqueACTIVEliftLENGTH As Single

Dim unusedSPRINGturnsFORlift As Single
Dim availableSPRINGturnsFORlift As Single
Dim maxFULLlayersatLIFTcapacity As Single
Dim extraWRAPSatLIFTcapacity As Single
Dim spooledcableINERTIAinsideRADIUS As Single
Dim spooledcableINERTIAoutsideRADIUSlift As Single
Dim spooledcableINERTIAlift As Single
Dim spoolFULLmomentARMlift As Single
Dim torqueTOliftPENDANT As Single
Dim pendantINERTIAlift As Single
Dim totalLIFTinertia As Single
Dim rpmSPOOLfullLIFT As Single
Dim torqueTOaccelerateREELlift As Single
Dim ADJpretensionTURNS As Single
Dim torqueFROMpretensionTURNSlift As Single

Dim extraWRAPSafterFULLLAYERStorqueLIFTr As Single

Dim FACMI As Single
Dim TTEL As Single


pendantTORQUEftlb = (pendantINlbs * momentARM * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
''write #1, "pendantTORQUEftlb: " & Str(pendantTORQUEftlb)
Tcabel = ((0.9003 * momentARM) * (pi * momentARM / 2! * cableWGT(1)) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
''write #1, "Tcabel: " & Str(Tcabel)
liftTORQUEftlb = adjustedTORQUE - torqueTOovercomeCOLLECTORfriction - CBEND
''write #1, "adjustedTORQUE: " & Str(adjustedTORQUE)
''write #1, "torqueTOovercomeCOLLECTORfriction: " & Str(torqueTOovercomeCOLLECTORfriction)
''write #1, "CBEND: " & Str(CBEND)
''write #1, "liftTORQUEftlb: " & Str(liftTORQUEftlb)
TBRGEL = (((adjustedTORQUE * 24 / drumSIZE) + spoolWEIGHT) * coefficient * 2! / drumSIZE) * drumSIZE / 24 * gearRATIO
''write #1, "TBRGEL: " & Str(TBRGEL)
''write #1, "spoolWEIGHT: " & Str(spoolWEIGHT)
''write #1, "coefficient: " & Str(coefficient)
TSPLEL = (reelINERTIA * gearRATIO ^ 2 * accelINftsecsec) / (RA * 32.16)
''write #1, "TSPLEL: " & Str(TSPLEL)
''write #1, "reelINERTIA: " & Str(reelINERTIA)
''write #1, "RA: " & Str(RA)
VLIFT = (liftTORQUEftlb - (TSPLEL + TBRGEL + Tcabel + pendantTORQUEftlb)) / (cableWGT(1) * momentARM * gearRATIO * (1! + (accelINftsecsec * gearRATIO / 32.16)))
''write #1, "VLIFT: " & Str(VLIFT)
RLMAX = VLIFT
IYIND = 1
extraWRAPSafterFULLLAYERStorqueLIFTr = 0
TEMPcircumferenceTOTAL = 0
maxWRAPSfromTORQUElift = 0
maxLENGTHcableFROMtorqueLIFT = 0


LINE440:
extraWRAPSafterFULLLAYERStorqueLIFTr = extraWRAPSafterFULLLAYERStorqueLIFTr + 1!
If extraWRAPSafterFULLLAYERStorqueLIFTr > IXARR(IYIND) Then GoTo LINE442
TEMPcircumferenceTOTAL = TEMPcircumferenceTOTAL + WRAP(IYIND)
If TEMPcircumferenceTOTAL <= RLMAX Then GoTo LINE440
GoTo LINE445

LINE442:
extraWRAPSafterFULLLAYERStorqueLIFTr = 0!
IYIND = IYIND + 1
GoTo LINE440
LINE445:
extraWRAPSafterFULLLAYERStorqueLIFTr = extraWRAPSafterFULLLAYERStorqueLIFTr - 1!
IYFIN = IYIND - 1
'maxWRAPSfromTORQUElift = 0
'maxLENGTHcableFROMtorqueLIFT = 0

If IYFIN = 0 Then GoTo LINE449
For IYIND = 1 To IYFIN
  maxWRAPSfromTORQUElift = maxWRAPSfromTORQUElift + IXARR(IYIND)
  maxLENGTHcableFROMtorqueLIFT = maxLENGTHcableFROMtorqueLIFT + Row(IYIND)
Next IYIND
LINE449:
IYIND = IYFIN + 1
maxWRAPSfromTORQUElift = maxWRAPSfromTORQUElift + extraWRAPSafterFULLLAYERStorqueLIFTr


EL = extraWRAPSafterFULLLAYERStorqueLIFTr
maxLENGTHcableFROMtorqueLIFT = maxLENGTHcableFROMtorqueLIFT + EL * WRAP(IYIND)
maxACTIVElengthOFcableFROMtorqueLIFT = maxLENGTHcableFROMtorqueLIFT
maxFULLLAYERSfromTORQUEliftR = IYFIN
If EL = 0 Then maxFULLLAYERSfromTORQUEliftR = IYFIN - 1

unusedSPRINGturnsFORlift = 0!
availableSPRINGturnsFORlift = 0!

If maxUSABLEwrapsR < springTURNSavailAFTERpretensionR Then GoTo LINE450

maxLIFTcapacityOFreel = turnsACTIVEcableLENGTH
maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTURNSr
unusedSPRINGturnsFORlift = 0
If maxWRAPSfromTORQUElift >= springTURNSavailAFTERpretensionR Then GoTo LINE448
maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTORQUEliftR
unusedSPRINGturnsFORlift = (springTURNSavailAFTERpretensionR - maxWRAPSfromTORQUElift) / gearRATIO

'compartment, torque or turns dictate reels capacity?
LINE448:
GoTo LINE452

LINE450:
maxLIFTcapacityOFreel = compartmentACTIVEcableLENGTH
unusedSPRINGturnsFORlift = 0!
availableSPRINGturnsFORlift = 0!
maxFULLlayersatLIFTcapacity = maxUSABLElayersR
If maxWRAPSfromTORQUElift >= maxUSABLEwrapsR Then GoTo LINE451
maxLIFTcapacityOFreel = maxACTIVElengthOFcableFROMtorqueLIFT
availableSPRINGturnsFORlift = (springTURNSavailAFTERpretensionR - maxUSABLEwrapsR) / gearRATIO
maxFULLlayersatLIFTcapacity = maxFULLLAYERSfromTORQUEliftR
LINE451:
LINE452:
spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
spooledcableINERTIAoutsideRADIUSlift = (drumSIZE + 2! * maxFULLlayersatLIFTcapacity * cableTHICK(1)) / 24!
spooledcableINERTIAlift = (cableWGT(1) * maxLIFTcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSlift ^ 2!)
spoolFULLmomentARMlift = (drumSIZE + (2! * maxFULLlayersatLIFTcapacity - 1!) * cableTHICK(1)) / 24!
totalLIFTinertia = reelINERTIA + spooledcableINERTIAlift                     '+ pendantINERTIAlift    check into this!!!!!!
TSPLFL = (totalLIFTinertia * gearRATIO ^ 2! * accelINftsecsec) / (spoolFULLmomentARMlift * 32.16)
TEMPB = pretensionTURNS * gearRATIO
ITEMPB = TEMPB
Call getCMspringDATA(Int(ITEMPB))
torqueTOaccelerateREELlift = springTORQUEavailFORreeling
''write #1, "torqueTOaccelerateREELlift: " & Str(torqueTOaccelerateREELlift)
TCABFL = ((0.9003 * spoolFULLmomentARMlift) * (cableWGT(1) * pi * spoolFULLmomentARMlift / 2!) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
''write #1, "TCABFL: " & Str(TCABFL)
TPENFL = (pendantINlbs * spoolFULLmomentARMlift * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
''write #1, "TPENFL: " & Str(TPENFL)
TBGRFL = (((totalLIFTinertia * 24 / drumSIZE) + spoolWEIGHT + (cableWGT(1) * maxLIFTcapacityOFreel)) * coefficient * 2! / drumSIZE) * drumSIZE / 24! * gearRATIO
''write #1, "TBGRFL: " & Str(TBGRFL)
''write #1, "TSPLFL: " & Str(TSPLFL)
''write #1, "torqueTOovercomeCOLLECTORfriction: " & Str(torqueTOovercomeCOLLECTORfriction)
''write #1, "CBEND: " & Str(CBEND)
netTORQUEwithREELfullLIFT = torqueTOaccelerateREELlift - (TSPLFL + torqueTOovercomeCOLLECTORfriction + CBEND + TBRGFL + TCABFL + TPENFL)

If specificINPUT(modelINDEX) = False Then
  ''write #1, "netTORQUEwithREELfullLIFT: " & Format(netTORQUEwithREELfullLIFT, "#.##")
  ''write #1, "availableSPRINGturnsFORlift: " & Str(availableSPRINGturnsFORlift)
  ''write #1, "unusedSPRINGturnsFORlift: " & Str(unusedSPRINGturnsFORlift)
  ''write #1, ""
  If netTORQUEwithREELfullLIFT < 0 Then
    Call invalidSTORE(3)
    Exit Sub
  End If
  If availableSPRINGturnsFORlift <> 0 Or unusedSPRINGturnsFORlift <> 0 Then
    Call invalidSTORE(4)
    Exit Sub
  End If
End If
If netTORQUEwithREELfullLIFT < 0 Or availableSPRINGturnsFORlift <> 0 Or unusedSPRINGturnsFORlift <> 0 Then invalidWARNING = True

validTORQUE = True

End Sub

Public Sub calcRETRIEVEapplCM()
Dim maxFULLlayersatRETRIEVEcapacity As Single
Dim spooledcableINERTIAinsideRADIUS As Single
Dim spooledcableINERTIAoutsideRADIUSretriev As Single
Dim spooledcableINERTIAretrieve As Single
Dim totalRETRIEVEinertia As Single
Dim spoolFULLmomentARMretrieve As Single
Dim torqueTOaccelerateREELretrieve As Single
Dim ADJpretensionTURNS As Integer
Dim ITEMPB As Integer
Dim torqueFROMpretensionTURNSretrieve As Single
Dim TCABFR As Single
Dim TBRGFR As Single

''write #1, "RETRIEVE CALCS FOR CM"
''write #1, "-----------------------------------------"
'RETRIEVE..... (check for adequate torque when reel is "almost " full)"
maximumRETRIEVEcapacityOFreel = compartmentACTIVEcableLENGTH
maxFULLlayersatRETRIEVEcapacity = maxUSABLElayersR

If turnsACTIVEcableLENGTH >= maximumRETRIEVEcapacityOFreel Then GoTo LINE485
maximumRETRIEVEcapacityOFreel = turnsACTIVEcableLENGTH
maxFULLlayersatRETRIEVEcapacity = maxFULLLAYERSfromTURNSr
''write #1, "maxFULLLAYERSfromTURNSr: " & Str(maxFULLLAYERSfromTURNSr)
LINE485:
spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
spooledcableINERTIAoutsideRADIUSretriev = (drumSIZE + 2! * maxFULLlayersatRETRIEVEcapacity * cableTHICK(1)) / 24!
''write #1, "spooledcableINERTIAoutsideRADIUSretriev: " & Str(spooledcableINERTIAoutsideRADIUSretriev)
''write #1, "maxFULLlayersatRETRIEVEcapacity: " & Str(maxFULLlayersatRETRIEVEcapacity)
spooledcableINERTIAretrieve = (cableWGT(1) * maximumRETRIEVEcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSretriev ^ 2!)
totalRETRIEVEinertia = reelINERTIA + spooledcableINERTIAretrieve
''write #1, "reelINERTIA: " & Str(reelINERTIA)
'write #1, "spooledcableINERTIAretrieve: " & Str(spooledcableINERTIAretrieve)

spoolFULLmomentARMretrieve = (drumSIZE + (2! * maxFULLlayersatRETRIEVEcapacity - 1!) * cableTHICK(1)) / 24!
torqueTOaccelerateREELretrieve = (totalRETRIEVEinertia * gearRATIO ^ 2! * accelINftsecsec) / (spoolFULLmomentARMretrieve * 32.16)
'write #1, "torqueTOaccelerateREELretrieve: " & Str(torqueTOaccelerateREELretrieve)
'write #1, "totalRETRIEVEinertia: " & Str(totalRETRIEVEinertia)
'write #1, "systemACCEL: " & Str(systemACCEL)
'write #1, "spoolFULLmomentARMretrieve: " & Str(spoolFULLmomentARMretrieve)
'write #1, "gearRATIO: " & Str(gearRATIO)


ADJpretensionTURNS = pretensionTURNS * gearRATIO
'write #1, "ADJpretensionTURNS: " & Str(ADJpretensionTURNS)
ITEMPB = Int(ADJpretensionTURNS)
Call getCMspringDATA(Int(ITEMPB))
torqueFROMpretensionTURNSretrieve = springTORQUEavailFORreeling
'write #1, "torqueFROMpretensionTURNSretrieve: " & Str(torqueFROMpretensionTURNSretrieve)

LINE490:
TCABFR = ((0.9003 * spoolFULLmomentARMretrieve) * (pi * spoolFULLmomentARMretrieve / 2! * cableWGT(1)) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
'write #1, "TCABFR: " & Str(TCABFR)
TBRGFR = (((torqueFROMpretensionTURNSretrieve * 24 / drumSIZE) + spoolWEIGHT + (cableWGT(1) * maximumRETRIEVEcapacityOFreel)) * coefficient * 2! / drumSIZE) * drumSIZE / 24! * gearRATIO
'write #1, "TBRGFR: " & Str(TBRGFR)
netTORQUEwithREELfullRETRIEVE = torqueFROMpretensionTURNSretrieve - (torqueTOaccelerateREELretrieve + torqueTOovercomeCOLLECTORfriction + CBEND + TCABFR + TBRGFR)
'write #1, "netTORQUEwithREELfullRETRIEVE: " & Str(netTORQUEwithREELfullRETRIEVE)
maxCENTERLINEheight = netTORQUEwithREELfullRETRIEVE / ((spoolFULLmomentARMretrieve * cableWGT(1) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16)))
'write #1, "maxCENTERLINEheight: " & Str(maxCENTERLINEheight)
If maxCENTERLINEheight < 0 Then maxCENTERLINEheight = 0
If maxCENTERLINEheight < centerlineINft Then
  Select Case specificINPUT(modelINDEX)
    Case False
      Call invalidSTORE(3)
      Exit Sub
    Case True
      invalidWARNING = True
  End Select
End If

validTORQUE = True

End Sub

Public Sub calcSTRETCHapplCM()

Dim IYFIN As Integer
Dim torqueACTIVEstretchLENGTH As Single
Dim TCABES As Single
Dim TBRGES As Single
Dim TSPLES As Single
Dim Stretch As Single
Dim SMAX As Single
Dim IYIND As Integer
Dim extraWRAPSafterFULLLAYERStorqueSTRETCHr As Single
Dim TEMPcircumferenceTOTAL As Single
Dim STRMAX As Single
Dim ES As Single
Dim YS As Single
Dim unusedSPRINGturnsFORstretch As Single
Dim availableSPRINGturnsFORstretch As Single
Dim maxFULLlayersatSTRETCHcapacity As Single
Dim spooledcableINERTIAinsideRADIUS As Single
Dim spooledcableINERTIAoutsideRADIUSstretch As Single
Dim spooledcableINERTIAstretch As Single
Dim totalSTRETCHinertia  As Single
Dim spoolFULLmomentARMstretch  As Single
Dim torqueTOaccelerateREELstretch  As Single
Dim ADJpretensionTURNS As Single
Dim ITEMPB As Integer
Dim torqueFROMpretensionTURNSstretch As Single
Dim TBRGFS As Single
Dim TCABFS As Single

'write #1, ""
'write #1, "Begin STRETCH CALCS FOR CM:"

If UCase(percentSAGstr) <> "STD" And percentSAGstr <> Null Then
  percentSAG = Val(percentSAGstr) / 100
Else
  percentSAG = 10 / 100   '10% std for CM
End If
SAGfactor = 1 / (percentSAG * 8)

torqueACTIVEstretchLENGTH = adjustedTORQUE - torqueTOovercomeCOLLECTORfriction - CBEND
'write #1, "torqueACTIVEstretchLENGTH: " & Str(torqueACTIVEstretchLENGTH)
TCABES = ((0.6366 * momentARM) * (cableWGT(1) * pi * momentARM) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
'write #1, "TCABES: " & Str(TCABES)
TBRGES = (((adjustedTORQUE * 24! / drumSIZE) + spoolWEIGHT) * coefficient * 2! / drumSIZE) * drumSIZE / 24! * gearRATIO
'write #1, "TBRGES: " & Str(TBRGES)
TSPLES = (reelINERTIA * gearRATIO ^ 2! * accelINftsecsec) / (RA * 32.16)
'write #1, "TSPLES: " & Str(TSPLES)
Stretch = (torqueACTIVEstretchLENGTH - (TSPLES + TBRGES + TCABES)) / SAGfactor / (cableWGT(1) * momentARM * gearRATIO * (1! + (accelINftsecsec * gearRATIO / 32.16)))
'write #1, "Stretch: " & Str(Stretch)
'write #1, "SAGfactor: " & Str(SAGfactor)
'write #1, "cableWGT(1): " & Str(cableWGT(1))
'write #1, "momentARM: " & Str(momentARM)
'write #1, "systemACCEL: " & Str(systemACCEL)
'write #1, "gearRATIO: " & Str(gearRATIO)


SMAX = Stretch
IYIND = 1
extraWRAPSafterFULLLAYERStorqueSTRETCHr = 0
TEMPcircumferenceTOTAL = 0
LINE460:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = extraWRAPSafterFULLLAYERStorqueSTRETCHr + 1!
If extraWRAPSafterFULLLAYERStorqueSTRETCHr > IXARR(IYIND) Then GoTo LINE462
TEMPcircumferenceTOTAL = TEMPcircumferenceTOTAL + WRAP(IYIND)
If TEMPcircumferenceTOTAL <= SMAX Then GoTo LINE460
GoTo LINE465
LINE462:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = 0!
IYIND = IYIND + 1!

GoTo LINE460
LINE465:
extraWRAPSafterFULLLAYERStorqueSTRETCHr = extraWRAPSafterFULLLAYERStorqueSTRETCHr - 1!
IYFIN = IYIND - 1!
maxWRAPSfromTORQUEstretch = 0
STRMAX = 0

If IYFIN = 0 Then GoTo LINE469
For IYIND = 1 To IYFIN
  maxWRAPSfromTORQUEstretch = maxWRAPSfromTORQUEstretch + IXARR(IYIND)
  STRMAX = STRMAX + Row(IYIND)
Next IYIND
LINE469:
IYIND = IYFIN + 1
maxWRAPSfromTORQUEstretch = maxWRAPSfromTORQUEstretch + extraWRAPSafterFULLLAYERStorqueSTRETCHr
ES = extraWRAPSafterFULLLAYERStorqueSTRETCHr
STRMAX = STRMAX + ES * WRAP(IYIND)
maxACTIVElengthOFcableFROMtorqueSTRETCH = STRMAX
YS = IYFIN
If ES = 0 Then YS = IYFIN - 1

unusedSPRINGturnsFORstretch = 0!
availableSPRINGturnsFORstretch = 0!
If maxUSABLEwrapsR < springTURNSavailAFTERpretensionR Then GoTo LINE470
maxSTRETCHcapacityOFreel = turnsACTIVEcableLENGTH
unusedSPRINGturnsFORstretch = 0!
maxFULLlayersatSTRETCHcapacity = maxFULLLAYERSfromTURNSr

If maxWRAPSfromTORQUEstretch >= springTURNSavailAFTERpretensionR Then GoTo LINE468
maxSTRETCHcapacityOFreel = maxACTIVElengthOFcableFROMtorqueSTRETCH
unusedSPRINGturnsFORstretch = (springTURNSavailAFTERpretensionR - maxWRAPSfromTORQUEstretch) / gearRATIO
maxFULLlayersatSTRETCHcapacity = YS

LINE468:
GoTo LINE472
LINE470:
maxSTRETCHcapacityOFreel = compartmentACTIVEcableLENGTH
unusedSPRINGturnsFORstretch = 0!
availableSPRINGturnsFORstretch = 0!
maxFULLlayersatSTRETCHcapacity = maxUSABLElayersR
If maxWRAPSfromTORQUEstretch >= maxUSABLEwrapsR Then GoTo LINE471
maxSTRETCHcapacityOFreel = maxACTIVElengthOFcableFROMtorqueSTRETCH
availableSPRINGturnsFORstretch = (springTURNSavailAFTERpretensionR - maxUSABLEwrapsR) / gearRATIO
maxFULLlayersatSTRETCHcapacity = YS

LINE471:
LINE472:
spooledcableINERTIAinsideRADIUS = drumSIZE / 24!
spooledcableINERTIAoutsideRADIUSstretch = (drumSIZE + 2! * maxFULLlayersatSTRETCHcapacity * cableTHICK(1)) / 24!
'write #1, "spooledcableINERTIAoutsideRADIUSstretch: " & Str(spooledcableINERTIAoutsideRADIUSstretch)
spooledcableINERTIAstretch = (cableWGT(1) * maxSTRETCHcapacityOFreel / 2!) * (spooledcableINERTIAinsideRADIUS ^ 2! + spooledcableINERTIAoutsideRADIUSstretch ^ 2!)
'write #1, "spooledcableINERTIAstretch: " & Str(spooledcableINERTIAstretch)
totalSTRETCHinertia = reelINERTIA + spooledcableINERTIAstretch
'write #1, "totalSTRETCHinertia: " & Str(totalSTRETCHinertia)
spoolFULLmomentARMstretch = (drumSIZE + (2! * maxFULLlayersatSTRETCHcapacity - 1!) * cableTHICK(1)) / 24!
'write #1, "spoolFULLmomentARMstretch: " & Str(spoolFULLmomentARMstretch)
torqueTOaccelerateREELstretch = (totalSTRETCHinertia * gearRATIO ^ 2! * accelINftsecsec) / (spoolFULLmomentARMstretch * 32.16)
'write #1, "torqueTOaccelerateREELstretch: " & Str(torqueTOaccelerateREELstretch)

ADJpretensionTURNS = pretensionTURNS * gearRATIO
ITEMPB = Int(ADJpretensionTURNS)
Call getCMspringDATA(ITEMPB)
torqueFROMpretensionTURNSstretch = springTORQUEavailFORreeling
'write #1, "torqueFROMpretensionTURNSstretch: " & Str(torqueFROMpretensionTURNSstretch)
LINE474:

TBRGFS = (((torqueFROMpretensionTURNSstretch * 24! / drumSIZE) + spoolWEIGHT + (cableWGT(1) * torqueACTIVEstretchLENGTH)) * coefficient * 2! / drumSIZE) * drumSIZE / 24! * gearRATIO
'write #1, "TBRGFS: " & Str(TBRGFS)
TCABFS = ((0.6366 * spoolFULLmomentARMstretch) * (pi * spoolFULLmomentARMstretch * cableWGT(1)) * gearRATIO) * (1! + (accelINftsecsec * gearRATIO / 32.16))
'write #1, "TCABFS: " & Str(TCABFS)
netTORQUEwithREELfullSTRETCH = torqueFROMpretensionTURNSstretch - (torqueTOaccelerateREELstretch + torqueTOovercomeCOLLECTORfriction + CBEND + TBRGFS + TCABFS)
'write #1, "netTORQUEwithREELfullSTRETCH: " & Str(netTORQUEwithREELfullSTRETCH)
'write #1, "availableSPRINGturnsFORstretch: " & Str(availableSPRINGturnsFORstretch)
'write #1, "unusedSPRINGturnsFORstretch: " & Str(unusedSPRINGturnsFORstretch)

If specificINPUT(modelINDEX) = False Then
  If netTORQUEwithREELfullSTRETCH < 0 Then
    Call invalidSTORE(3)
    Exit Sub
  End If
  If availableSPRINGturnsFORstretch <> 0 Or unusedSPRINGturnsFORstretch <> 0 Then
    Call invalidSTORE(4)
    Exit Sub
  End If
End If
If netTORQUEwithREELfullSTRETCH < 0 Or availableSPRINGturnsFORstretch <> 0 Or unusedSPRINGturnsFORstretch <> 0 Then invalidWARNING = True
validTORQUE = True

End Sub

Public Sub calcACCpn()


End Sub

Public Sub accessUreel()
Dim testSTR As String
'2013 prices
If optANDacc(optPNTR).rollerGUIDEresp Then
     testSTR = validREEL(reelPNTR).FRAME + reelWIDTHinp
     Select Case UCase(optANDacc(optPNTR).rollerGUIDEappl)
       Case "HORIZONTAL"
         Select Case testSTR
           Case "1806", "2106": rollerguidePN = "GR042195"
           Case "1808", "2108": rollerguidePN = "GR042196"
           Case "1810", "2110": rollerguidePN = "GR042197"
           Case "1812", "2112": rollerguidePN = "GR042198"
           Case "1814", "2114": rollerguidePN = "GR042199"
           Case "2406": rollerguidePN = "GR042200"
           Case "2408": rollerguidePN = "GR042201"
           Case "2410": rollerguidePN = "GR042202"
           Case "2412": rollerguidePN = "GR042203"
           Case "2414": rollerguidePN = "GR042204"
           Case "2806": rollerguidePN = "GR042205"
           Case "2808": rollerguidePN = "GR042206"
           Case "2810": rollerguidePN = "GR042207"
           Case "2812": rollerguidePN = "GR042208"
           Case "2814": rollerguidePN = "GR042209"
           Case "3206": rollerguidePN = "GR042210"
           Case "3208": rollerguidePN = "GR042211"
           Case "3210": rollerguidePN = "GR042212"
           Case "3212": rollerguidePN = "GR042213"
           Case "3214": rollerguidePN = "GR042214"
           Case Else: rollerguidePN = "XXXXXX"
         End Select
       Case "VERTICAL"
         Select Case testSTR
           Case "1806", "2106", "2406": rollerguidePN = "GR042270"
           Case "1808", "2108", "2408": rollerguidePN = "GR042271"
           Case "1810", "2110", "2410": rollerguidePN = "GR042272"
           Case "1812", "2112", "2412": rollerguidePN = "GR042273"
           Case "1814", "2114", "2414": rollerguidePN = "GR042274"
           Case "2806", "3206": rollerguidePN = "GR042275"
           Case "2808", "3208": rollerguidePN = "GR042276"
           Case "2810", "3210": rollerguidePN = "GR042277"
           Case "2812", "3212": rollerguidePN = "GR042278"
           Case "2814", "3214": rollerguidePN = "GR042279"
           Case Else: rollerguidePN = "XXXXXX"
         End Select
     End Select
     rollerguidePRICE = 156
   End If

   If optANDacc(optPNTR).limitSWITCHresp Then
     Select Case validREEL(reelPNTR).FRAME
       Case "32":  limitswitchPN = "XXXXXX"
       Case Else:  limitswitchPN = "XXXXXX"
     End Select
     limitswitchPRICE = 1345
   End If

   If optANDacc(optPNTR).hoopGUIDEresp Then
    Select Case validREEL(reelPNTR).FRAME
      Case "18":  hoopguidePN = "GR057199":  hoopguidePRICE = 301
      Case "21":  hoopguidePN = "GR057200":  hoopguidePRICE = 324
      Case "24":  hoopguidePN = "GR057201":  hoopguidePRICE = 335
      Case "28":  hoopguidePN = "GR057202":  hoopguidePRICE = 348
      Case "32":  hoopguidePN = "GR057203":  hoopguidePRICE = 356
    End Select
  End If

   If optANDacc(optPNTR).pivotBASEresp Then
     validREEL(reelPNTR).modelWGT = validREEL(reelPNTR).modelWGT + 64
     Select Case reelWIDTHinp
       Case "GR04", "06": pivotbasePN = "GR042284"
       Case "08", "10": pivotbasePN = "GR042285"
       Case "12", "14": pivotbasePN = "GR042286"
     End Select
     pivotbasePRICE = 694
   End If

   If optANDacc(optPNTR).dogRATCHETresp Then
     If optANDacc(optPNTR).revROTATEresp Then
       dogratchetPN = "GR042231"
     Else
       dogratchetPN = "GR042230"
     End If
     dogratchetPRICE = 178
   End If

   If optANDacc(optPNTR).spoolLOCKresp Then
     spoollockPN = "GR042227": spoollockPRICE = 94
   End If

   If optANDacc(optPNTR).ballSTOPresp Then
     Select Case cableTHICK(1)
       Case Is < 0.62: ballstopPN = "GR037529":  ballstopPRICE = 73
       Case Is > 1.87: ballstopPN = "GR041846":  ballstopPRICE = 157
       Case Is > 1.55: ballstopPN = "GR041845":  ballstopPRICE = 153
       Case Is > 1.38:  ballstopPN = "GR037537":  ballstopPRICE = 142
       Case Is > 1.3:  ballstopPN = "GR037536":  ballstopPRICE = 131
       Case Is > 1.05
         Select Case Val(optANDacc(optPNTR).ballSTOPsize)
           Case 3:  ballstopPN = "GR037533":  ballstopPRICE = 111
           Case 3.5:  ballstopPN = "GR037536":  ballstopPRICE = 131
         End Select
       Case Is > 0.75
         Select Case Val(optANDacc(optPNTR).ballSTOPsize)
           Case 3:  ballstopPN = "GR037532":  ballstopPRICE = 111
           Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 131
         End Select
       Case Is = 0.75
         Select Case Val(optANDacc(optPNTR).ballSTOPsize)
           Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
           Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
         End Select
       Case Is >= 0.62
         Select Case Val(optANDacc(optPNTR).ballSTOPsize)
           Case 2.5:  ballstopPN = "GR037530":  ballstopPRICE = 73
           Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
         End Select
      End Select
   End If

'hose clamps required for all UH & HM reels
If cableORhose = "HS" Then Call getHOSEfittings

End Sub

Public Sub accessSreel()
'2013 prices
If optANDacc(optPNTR).rollerGUIDEresp Then
    If Not (optANDacc(optPNTR).hoopGUIDEresp) Then
      Select Case UCase(optANDacc(optPNTR).rollerGUIDEmatl)
        Case "STEEL":
          Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
            Case "HORIZONTAL", "VERTICAL"
              If Not optANDacc(optPNTR).revROTATEresp Then
                Select Case validREEL(reelPNTR).FRAME
                  Case "16", "18", "21": rollerguidePN = "GR035220": rollerguidePRICE = 365
                  Case "24": rollerguidePN = "GR035221": rollerguidePRICE = 365
                  Case "28", "32": rollerguidePN = "GR035222": rollerguidePRICE = 385
                End Select
              Else
               Select Case validREEL(reelPNTR).FRAME
                 Case "16", "18", "21": rollerguidePN = "GR035223": rollerguidePRICE = 365
                 Case "24": rollerguidePN = "GR035224": rollerguidePRICE = 365
                 Case "28", "32": rollerguidePN = "GR035225": rollerguidePRICE = 385
               End Select
              End If
            Case "VERTICAL DOWN"
              Select Case validREEL(reelPNTR).FRAME
                Case "16", "18", "21", "24": rollerguidePN = "GR035226": rollerguidePRICE = 395
                Case "28", "32": rollerguidePN = "GR035227": rollerguidePRICE = 414
              End Select
          End Select
        Case "NYLON":
          Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
            Case "HORIZONTAL", "VERTICAL"
              Select Case validREEL(reelPNTR).FRAME
                Case "14": rollerguidePN = "GR012079"
                Case "16", "18", "21": rollerguidePN = "GR012082"
                Case "24": rollerguidePN = "GR012085"
                Case "28": rollerguidePN = "GR012087"
                Case "32": rollerguidePN = "GR04045401"
              End Select
              rollerguidePRICE = 160
            Case "VERTICAL DOWN"
              Select Case validREEL(reelPNTR).FRAME
                Case "14", "16", "18", "21", "24": rollerguidePN = "GR012084"
                Case "28": rollerguidePN = "GR012089"
                Case "32": rollerguidePN = "GR040457"
              End Select
              rollerguidePRICE = 156
          End Select
      End Select
    Else                          'hoop guide yes so MMD roller guide required
      Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEmatl))
        Case "STEEL":
          Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
            Case "HORIZONTAL", "VERTICAL"
              Select Case validREEL(reelPNTR).FRAME
                Case "18", "21", "24": rollerguidePN = "GR034742": rollerguidePRICE = 394
                Case "28", "32": rollerguidePN = "GR034743": rollerguidePRICE = 413
              End Select
            Case "VERTICAL DOWN"
              Select Case validREEL(reelPNTR).FRAME
                Case "18", "21", "24": rollerguidePN = "GR034744": rollerguidePRICE = 420
                Case "28", "32": rollerguidePN = "GR034745": rollerguidePRICE = 436
              End Select
          End Select
        Case "NYLON":
          Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
            Case "HORIZONTAL", "VERTICAL"
              Select Case validREEL(reelPNTR).FRAME
                Case "18", "21", "24": rollerguidePN = "GR015607": rollerguidePRICE = 208
                Case "28", "32": rollerguidePN = "GR015608": rollerguidePRICE = 220
              End Select
            Case "VERTICAL DOWN"
              Select Case validREEL(reelPNTR).FRAME
                Case "18", "21", "24": rollerguidePN = "GR015674": rollerguidePRICE = 186
                Case "28", "32": rollerguidePN = "GR015675": rollerguidePRICE = 186
              End Select
          End Select
      End Select
    End If
    If optANDacc(optPNTR).hazardDUTYresp Then rollerguidePN = "XXXXXX"  'per S. schmitz, uses steel pricing, diff P/N
  End If

  If optANDacc(optPNTR).hoopGUIDEresp Then
    Select Case validREEL(reelPNTR).FRAME
      Case "18":  hoopguidePN = "GR012095":  hoopguidePRICE = 301
      Case "21":  hoopguidePN = "GR012096":  hoopguidePRICE = 324
      Case "24":  hoopguidePN = "GR012097":  hoopguidePRICE = 335
      Case "28":  hoopguidePN = "GR012098":  hoopguidePRICE = 348
      Case "32":  hoopguidePN = "GR039712":  hoopguidePRICE = 356
    End Select
  End If

  If optANDacc(optPNTR).limitSWITCHresp Then
    Select Case validREEL(reelPNTR).FRAME
      Case "32":  limitswitchPN = "GR040449"
      Case Else:  limitswitchPN = "GR012092"
    End Select
    limitswitchPRICE = 1674
  End If

  If optANDacc(optPNTR).pivotBASEresp Then
    Select Case validREEL(reelPNTR).FRAME
      Case "14":  pivotbasePN = "GR012076":  pivotbasePRICE = 301
      Case "16", "18", "21", "24", "28", "32": pivotbasePN = "GR012077": pivotbasePRICE = 720
    End Select
    If optANDacc(optPNTR).hazardDUTYresp Then
      pivotbasePN = "GR0120771": pivotbasePRICE = 776  '2013 manually change make sure it matches MMD access
    End If
  End If

  If optANDacc(optPNTR).dogRATCHETresp Then
    Select Case optANDacc(optPNTR).hazardDUTYresp
      Case yes: dogratchetPN = "XXXXXX": dogratchetPRICE = 504   '2013 manually change make sure it matches MMD access
      Case no:
        Select Case validREEL(reelPNTR).FRAME
          Case "32":  dogratchetPN = "GR039887"
          Case Else:  dogratchetPN = "GR012090"
        End Select
        dogratchetPRICE = 456
    End Select
  End If

  If optANDacc(optPNTR).spoolLOCKresp Then
    spoollockPN = "GR012091": spoollockPRICE = 114
  End If

  If optANDacc(optPNTR).ballSTOPresp Then
    Select Case cableTHICK(1)
      Case Is < 0.62: ballstopPN = "GR037529":  ballstopPRICE = 73
      Case Is > 1.87: ballstopPN = "GR041846":  ballstopPRICE = 157
      Case Is > 1.55: ballstopPN = "GR041845":  ballstopPRICE = 153
      Case Is > 1.38:  ballstopPN = "GR037537":  ballstopPRICE = 142
      Case Is > 1.3:  ballstopPN = "GR037536":  ballstopPRICE = 131
      Case Is > 1.05
        Select Case Val(optANDacc(optPNTR).ballSTOPsize)
          Case 3:  ballstopPN = "GR037533":  ballstopPRICE = 111
          Case 3.5:  ballstopPN = "GR037536":  ballstopPRICE = 131
        End Select
      Case Is > 0.75
        Select Case Val(optANDacc(optPNTR).ballSTOPsize)
          Case 3:  ballstopPN = "GR037532":  ballstopPRICE = 111
          Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
        End Select
      Case Is = 0.75
        Select Case Val(optANDacc(optPNTR).ballSTOPsize)
          Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
          Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
        End Select
      Case Is >= 0.62
        Select Case Val(optANDacc(optPNTR).ballSTOPsize)
          Case 2.5:  ballstopPN = "GR037530":  ballstopPRICE = 73
          Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
        End Select
     End Select
  End If

  If optANDacc(optPNTR).cableGRIPresp Then
     Select Case cableTHICK(1)
       Case Is >= 1.25: cablegripPN = "GR027618": cablegripPRICE = 192
       Case Is >= 1!: cablegripPN = "GR027617": cablegripPRICE = 186
       Case Is >= 0.75: cablegripPN = "GR027616": cablegripPRICE = 145
       Case Is >= 0.53: cablegripPN = "GR027615": cablegripPRICE = 134
       Case Is >= 0.41: cablegripPN = "GR027614": cablegripPRICE = 114
    End Select
  End If

End Sub

Public Sub accessSMreel()
'2013 prices
If optANDacc(optPNTR).rollerGUIDEresp Then
    Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
      Case "HORIZONTAL", "VERTICAL"
      Select Case validREEL(reelPNTR).FRAME
        Case "21", "24": rollerguidePN = "GR015988":   rollerguidePRICE = 532
        Case "28", "32": rollerguidePN = "GR015991": rollerguidePRICE = 532
      End Select
    Case "VERTICAL DOWN"
      Select Case validREEL(reelPNTR).FRAME
        Case "21", "24": rollerguidePN = "GR015989":   rollerguidePRICE = 568
        Case "28", "32": rollerguidePN = "GR015992": rollerguidePRICE = 591
      End Select
  End Select
End If


If optANDacc(optPNTR).limitSWITCHresp Then
  Select Case validREEL(reelPNTR).FRAME
    Case "21", "24": limitswitchPN = "GR015990": limitswitchPRICE = 1674
    Case "28": limitswitchPN = "GR015993": limitswitchPRICE = 1674
    Case "32": limitswitchPN = "GR039373": limitswitchPRICE = 1674
  End Select
End If


If optANDacc(optPNTR).pivotBASEresp Then
  Select Case validREEL(reelPNTR).FRAME
    Case "21", "24": pivotbasePN = "GR015874":  pivotbasePRICE = 3292
    Case "28", "32": pivotbasePN = "GR015873":  pivotbasePRICE = 5117
  End Select
End If


If optANDacc(optPNTR).dogRATCHETresp Then
 Select Case validREEL(reelPNTR).FRAME
  Case "32":
    dogratchetPN = "GR039887": dogratchetPRICE = 456
  Case Else:
    dogratchetPN = "GR012090": dogratchetPRICE = 456
  End Select
End If


If optANDacc(optPNTR).ballSTOPresp Then
  Select Case cableTHICK(1)
    Case Is < 0.62: ballstopPN = "GR037529":  ballstopPRICE = 73
    Case Is > 1.87: ballstopPN = "GR041846":  ballstopPRICE = 157
    Case Is > 1.55: ballstopPN = "GR041845":  ballstopPRICE = 153
    Case Is > 1.38:  ballstopPN = "GR037537":  ballstopPRICE = 142
    Case Is > 1.3:  ballstopPN = "GR037536":  ballstopPRICE = 131
    Case Is > 1.05
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 3:  ballstopPN = "GR037533":  ballstopPRICE = 111
        Case 3.5:  ballstopPN = "GR037536":  ballstopPRICE = 131
      End Select
    Case Is > 0.75
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 3:  ballstopPN = "GR037532":  ballstopPRICE = 111
        Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
      End Select
    Case Is = 0.75
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 2.5:  ballstopPN = "GR037530":  ballstopPRICE = 72
        Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
        Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
      End Select
    Case Is >= 0.62
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 2.5:  ballstopPN = "GR037530":  ballstopPRICE = 73
        Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
      End Select
   End Select
End If

If optANDacc(optPNTR).cableGRIPresp Then
   Select Case cableTHICK(1)
     Case Is >= 1.25: cablegripPN = "GR027618": cablegripPRICE = 192
     Case Is >= 1!: cablegripPN = "GR027617": cablegripPRICE = 186
     Case Is >= 0.75: cablegripPN = "GR027616": cablegripPRICE = 145
     Case Is >= 0.53: cablegripPN = "GR027615": cablegripPRICE = 134
     Case Is >= 0.41: cablegripPN = "GR027614": cablegripPRICE = 114
  End Select
End If

End Sub

Public Sub accessMMDreel()
'2013 prices
If optANDacc(optPNTR).rollerGUIDEresp Then
  Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEmatl))
    Case "STEEL":
      Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
        Case "HORIZONTAL", "VERTICAL"
          Select Case validREEL(reelPNTR).FRAME
            Case "21", "24": rollerguidePN = "GR034742":   rollerguidePRICE = 394
            Case "28", "32": rollerguidePN = "GR034743": rollerguidePRICE = 413
          End Select
        Case "VERTICAL DOWN"
          Select Case validREEL(reelPNTR).FRAME
            Case "21", "24": rollerguidePN = "GR034744":   rollerguidePRICE = 420
            Case "28", "32": rollerguidePN = "GR034745": rollerguidePRICE = 436
          End Select
      End Select
    Case "NYLON":
      Select Case UCase(Trim(optANDacc(optPNTR).rollerGUIDEappl))
        Case "HORIZONTAL", "VERTICAL"
          Select Case validREEL(reelPNTR).FRAME
            Case "21", "24": rollerguidePN = "GR015607":   rollerguidePRICE = 208
            Case "28", "32": rollerguidePN = "GR015608": rollerguidePRICE = 220
          End Select
        Case "VERTICAL DOWN"
          Select Case validREEL(reelPNTR).FRAME
            Case "21", "24": rollerguidePN = "GR015674":   rollerguidePRICE = 186
            Case "28", "32": rollerguidePN = "GR015675": rollerguidePRICE = 186
          End Select
      End Select
  End Select
End If


If optANDacc(optPNTR).limitSWITCHresp Then
  limitswitchPN = "GR012092": limitswitchPRICE = 1674
End If


If optANDacc(optPNTR).pivotBASEresp Then
  Select Case validREEL(reelPNTR).FRAME
    Case "21", "24": pivotbasePN = "GR012077": pivotbasePRICE = 720
    Case "28", "32": pivotbasePN = "GR012077":  pivotbasePRICE = 720
  End Select
  If optANDacc(optPNTR).hazardDUTYresp Then
    pivotbasePN = "GR0120771": pivotbasePRICE = 776 'manually bump to match S reel 2013
  End If
End If


If optANDacc(optPNTR).dogRATCHETresp Then
  Select Case optANDacc(optPNTR).hazardDUTYresp
    Case yes: dogratchetPN = "XXXXXX": dogratchetPRICE = 504 'manually bump to match S reel 2013
    Case no:
      Select Case validREEL(reelPNTR).FRAME
        Case "32": dogratchetPN = "GR039887": dogratchetPRICE = 456
        Case Else: dogratchetPN = "GR012090": dogratchetPRICE = 456
      End Select
  End Select
End If


If optANDacc(optPNTR).ballSTOPresp Then
  Select Case cableTHICK(1)
    Case Is < 0.62: ballstopPN = "GR037529":  ballstopPRICE = 73
    Case Is > 1.87: ballstopPN = "GR041846":  ballstopPRICE = 155
    Case Is > 1.55: ballstopPN = "GR041845":  ballstopPRICE = 153
    Case Is > 1.38:  ballstopPN = "GR037537":  ballstopPRICE = 142
    Case Is > 1.3:  ballstopPN = "GR037536":  ballstopPRICE = 131
    Case Is > 1.05
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 3:  ballstopPN = "GR037533":  ballstopPRICE = 111
        Case 3.5:  ballstopPN = "GR037536":  ballstopPRICE = 131
      End Select
    Case Is > 0.75
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 3:  ballstopPN = "GR037532":  ballstopPRICE = 111
        Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
      End Select
    Case Is = 0.75
      Select Case Val(optANDacc(optPNTR).ballSTOPsize)
        Case 3:  ballstopPN = "GR037531":  ballstopPRICE = 73
        Case 3.5:  ballstopPN = "GR037535":  ballstopPRICE = 125
      End Select
    Case Is >= 0.62
       ballstopPN = "GR037531":  ballstopPRICE = 73
    End Select
End If

If optANDacc(optPNTR).cableGRIPresp Then
   Select Case cableTHICK(1)
     Case Is >= 1.25: cablegripPN = "GR027618": cablegripPRICE = 192
     Case Is >= 1!: cablegripPN = "GR027617": cablegripPRICE = 186
     Case Is >= 0.75: cablegripPN = "GR027616": cablegripPRICE = 145
     Case Is >= 0.53: cablegripPN = "GR027615": cablegripPRICE = 134
     Case Is >= 0.41: cablegripPN = "GR027614": cablegripPRICE = 114
  End Select
End If


End Sub

Public Sub accessSHOTMRreel()

'2013 prices
If optANDacc(optPNTR).limitSWITCHresp Then
  Select Case validREEL(reelPNTR).SERIES
    Case "SHO": limitswitchPN = "GR020831": limitswitchPRICE = 1578
    Case "TMR": limitswitchPN = "GR020831": limitswitchPRICE = 1578
  End Select
End If

If optANDacc(optPNTR).cableGRIPresp Then
   Select Case cableTHICK(1)
     Case Is >= 1.25: cablegripPN = "GR027618": cablegripPRICE = 192
     Case Is >= 1!: cablegripPN = "GR027617": cablegripPRICE = 186
     Case Is >= 0.75: cablegripPN = "GR027616": cablegripPRICE = 145
     Case Is >= 0.53: cablegripPN = "GR027615": cablegripPRICE = 134
     Case Is >= 0.41: cablegripPN = "GR027614": cablegripPRICE = 114
  End Select
End If

End Sub

Public Sub accessCMreel()

If optANDacc(optPNTR).pivotBASEresp Then
  Select Case validREEL(reelPNTR).FRAME
    Case "14": pivotbasePN = "GR022217":  pivotbasePRICE = 120.55 '2013 prices
    Case "16": pivotbasePN = "GR028056":  pivotbasePRICE = 162.1
    Case "19": pivotbasePN = "GR022220":  pivotbasePRICE = 262.9
  End Select
End If

If optANDacc(optPNTR).ballSTOPresp Then
  Select Case cableTHICK(1)
    Case Is >= 0.7:  ballstopPN = "GR022452"
    Case Is >= 0.57:  ballstopPN = "GR022451"
    Case Is >= 0.47: ballstopPN = "GR022450"
    Case Is >= 0.25: ballstopPN = "GR033030"
   End Select
   ballstopPRICE = 22.45
End If

If optANDacc(optPNTR).cableGRIPresp Then
   Select Case cableTHICK(1)
     Case Is >= 1!: cablegripPN = "GR602063": cablegripPRICE = 101.85
     Case Is >= 0.75: cablegripPN = "GR602062": cablegripPRICE = 83.25
     Case Is >= 0.63: cablegripPN = "GR602061": cablegripPRICE = 72.2
     Case Is >= 0.5: cablegripPN = "GR602060": cablegripPRICE = 65.6
  End Select
End If

'hose clamps required for all UH & HM reels
If cableORhose = "HS" Then Call getHOSEfittings

End Sub

 Sub accessCLEARvariables()

rollerguidePN = ""
rollerguidePRICE = 0
hoopguidePN = ""
hoopguidePRICE = 0
limitswitchPN = ""
limitswitchPRICE = 0
pivotbasePN = ""
pivotbasePRICE = 0
dogratchetPN = ""
dogratchetPRICE = 0
spoollockPN = ""
spoollockPRICE = 0
ballstopPN = ""
ballstopPRICE = 0
cablegripPN = ""
cablegripPRICE = 0

End Sub


Public Sub accessKreel()
If optANDacc(optPNTR).dogRATCHETresp Then
   dogratchetPN = "GR014209": dogratchetPRICE = 293 '2013 price  reels pg 40
End If

End Sub

Public Sub calcEXTRAcable()

Dim subscrpt1 As String, subscrpt2 As String
Dim cableATreel As Integer
extraCABLEatREEL = 0

Select Case srchCOLL
      Case "23", "33", "43": subscrpt2 = "1"
      Case "63", "83": subscrpt2 = "2"
      Case "103", "123", "143", "163", "312": subscrpt2 = "3"
      Case "203": subscrpt2 = "4"
      Case "243": subscrpt2 = "5"
      Case "303": subscrpt2 = "6"
      Case "363": subscrpt2 = "7"
      Case "27", "37", "47", "212", "412", "220", "320", "420": subscrpt2 = "8"
      Case Else: subscrpt2 = "7"         'if collector not in list - conservative
End Select
Select Case srchSTYLE
  Case "U", "S", "SM", "MMD", "P":
    subscrpt1 = Str(drumSIZE - 7)
    Select Case srchCOLL
      Case "23", "33", "43": subscrpt2 = "1"
      Case "63", "83": subscrpt2 = "2"
      Case "103", "123", "143", "163", "312": subscrpt2 = "3"
      Case "203": subscrpt2 = "4"
      Case "243": subscrpt2 = "5"
      Case "303": subscrpt2 = "6"
      Case "363": subscrpt2 = "7"
      Case "27", "37", "47", "212", "412", "220", "320", "420": subscrpt2 = "8"
      Case Else: subscrpt2 = "7"         'if collector not in list - conservative
    End Select
    Select Case Trim(Trim(subscrpt2) & Trim(subscrpt1))
      Case "11": cableATreel = 4
      Case "12", "13", "14", "21", "22", "23", "31", "32", "41", "81", "82", "83": cableATreel = 5
      Case "15", "16", "17", "24", "25", "26", "33", "34", "35", "42", "43", "44", "51", "52", "53", "61", "62", "71", "84", "85", "86": cableATreel = 6
      Case "18", "19", "110", "27", "28", "29", "36", "37", "38", "45", "46", "47", "54", "55", "56", "63", "64", "65", "72", "73", "74", "87", "88", "89": cableATreel = 7
      Case "111", "112", "113", "210", "211", "212", "39", "310", "311", "48", "49", "410", "57", "58", "59", "66", "67", "68", "75", "76", "77", "810", "811", "812": cableATreel = 8
      Case "114", "115", "116", "213", "214", "215", "312", "313", "314", "411", "412", "413", "510", "511", "512", "69", "610", "611", "78", "79", "710", "813", "814", "815": cableATreel = 9
      Case "117", "118", "119", "216", "217", "218", "315", "316", "317", "414", "415", "416", "513", "514", "515", "612", "613", "614", "711", "712", "713", "816", "817", "818": cableATreel = 10
      Case "120", "121", "219", "220", "221", "318", "319", "320", "417", "418", "419", "516", "517", "518", "615", "616", "617", "714", "715", "716", "819", "820", "821": cableATreel = 11
      Case "321", "420", "421", "519", "520", "521", "618", "619", "620", "717", "718", "719": cableATreel = 12
      Case "621", "720", "721": cableATreel = 13
    End Select

    If deadWRAPS >= 1 Then
      extraCABLEatREEL = cableATreel + ((deadWRAPS - 1) * (drumSIZE + cableTHICK(1)) * pi / 12!)
    Else
      extraCABLEatREEL = cableATreel
    End If

    If srchSTYLE = "SM" Then
      Select Case srchCOLL
       Case "220", "320", "420": extraCABLEatREEL = extraCABLEatREEL + 1
      End Select
    End If
  Case "SHO", "TMR":
    Select Case srchCOLL
      Case "23", "33", "43": subscrpt2 = "1"
      Case "63", "83", "27", "37", "47", "212", "220", "320": subscrpt2 = "2"
      Case "103", "123", "312", "412", "420": subscrpt2 = "3"
      Case "143", "163": subscrpt2 = "4"
      Case "203": subscrpt2 = "5"
      Case "243": subscrpt2 = "6"
      Case "303": subscrpt2 = "7"
      Case "363": subscrpt2 = "8"
      Case Else: subscrpt2 = "8"         'if collector not in list - conservative
    End Select
    Select Case Trim(Str(drumSIZE))
      Case "14": subscrpt1 = "1"
      Case "16": subscrpt1 = "2"
      Case "18": subscrpt1 = "3"
      Case "20": subscrpt1 = "4"
      Case "22": subscrpt1 = "5"
      Case "24": subscrpt1 = "6"
      Case "26": subscrpt1 = "7"
      Case "28": subscrpt1 = "8"
      Case "30": subscrpt1 = "9"
      Case "32": subscrpt1 = "10"
      Case "34": subscrpt1 = "11"
      Case "36": subscrpt1 = "12"
      Case "38": subscrpt1 = "13"
      Case "40": subscrpt1 = "14"
      Case "42": subscrpt1 = "15"
      Case "44": subscrpt1 = "16"
      Case "46": subscrpt1 = "17"
      Case "48": subscrpt1 = "18"
    End Select

    Select Case Trim(Trim(subscrpt2) & Trim(subscrpt1))
      Case "11", "12", "21", "31", "41": cableATreel = 9
      Case "13", "22", "23", "32", "42", "52", "51", "61", "71", "81": cableATreel = 10
      Case "62", "72", "82", "33", "43", "53", "63", "14", "24", "34", "44", "15": cableATreel = 11
      Case "73", "83", "54", "64", "74", "84", "25", "35", "45", "55", "16", "26": cableATreel = 12
      Case "65", "75", "85", "36", "46", "56", "66", "17", "27", "37", "47", "18": cableATreel = 13
      Case "76", "86", "57", "67", "77", "87", "28", "38", "48", "58", "29", "39": cableATreel = 14
      Case "68", "78", "88", "39", "49", "59", "69", "79", "110", "210", "310", "410", "111": cableATreel = 15
      Case "89", "510", "610", "710", "810", "211", "311", "411", "511", "611", "112", "212", "312": cableATreel = 16
      Case "711", "811", "412", "512", "612", "712", "113", "213", "313", "413", "114": cableATreel = 17
      Case "812", "513", "613", "713", "813", "214", "314", "414", "514", "614", "115", "215", "315": cableATreel = 18
      Case "714", "814", "415", "515", "615", "715", "116", "216", "316", "416", "117": cableATreel = 19
      Case "815", "516", "616", "716", "816", "217", "317", "417", "517", "617", "118", "218", "318": cableATreel = 20
      Case "717", "817", "418", "518", "618", "718": cableATreel = 21
      Case "818": cableATreel = 22
    End Select

    If deadWRAPS >= 1 Then
      extraCABLEatREEL = cableATreel + ((deadWRAPS - 1) * (drumSIZE + cableTHICK(1)) * pi / 12!)
    Else
      extraCABLEatREEL = cableATreel
    End If
    Case "K":
      extraCABLEatREEL = Int(deadWRAPlength) + 1
    Case "C", "HM":
      If deadWRAPS >= 1 Then
        extraCABLEatREEL = 5 + ((deadWRAPS - 1) * (drumSIZE + cableTHICK(1)) * pi / 12!)
      Else
        extraCABLEatREEL = 5
      End If
End Select

End Sub

Public Sub writeDETAILSappl()
Dim unitsSEL As String, pkgDESC As String
Dim ftORm As String
Dim lbsORkg As String
Dim ftmsec As String
Dim ftm2sec As String
Dim tempunit As String



Print #1, "CALCULATION SUMMARY FOR: " & customerNAME
Print #1, "Date Prepared: " & Format(Date, "mm/dd/yyyy")
Select Case metricDEFAULT
  Case True: unitsSEL = "METRIC"
  Case False: unitsSEL = "STANDARD"
End Select
Print #1, "Units of measurement: " & unitsSEL
Print #1,
'prepare cable/hose desc
Select Case cableORhose
  Case "HD", "HS":
    Select Case metricDEFAULT
      Case True: pkgDESC = pkgDESC & Cable(1).style & Space(1) & Cable(1).ID & " mm" & " I.D. "
      Case False: pkgDESC = pkgDESC & Cable(1).style & Space(1) & Cable(1).ID & Chr(34) & " I.D. "
    End Select
    If cableORhose = "HD" Then pkgDESC = pkgDESC & "w/fittings"
  Case Else:
    pkgDESC = pkgDESC & "Round "
     If Cable(1).itemTYPE = "O" Or Cable(1).itemTYPE = "HV" Then 'High Voltage Cable
        Select Case Val(Cable(1).VOLTAGE)
          Case 600: pkgDESC = pkgDESC & "600V "
          Case 5000: pkgDESC = pkgDESC & "5 KV "
          Case 8000: pkgDESC = pkgDESC & "8 KV "
          Case 15000: pkgDESC = pkgDESC & "15 KV "
        End Select
      Else
        pkgDESC = pkgDESC & Cable(1).itemTYPE & Space(1)
      End If
      pkgDESC = pkgDESC & Cable(1).COND & "C-"
    Select Case metricDEFAULT
      Case True: pkgDESC = pkgDESC & Cable(1).AWG & "mm2"
      Case False: pkgDESC = pkgDESC & Cable(1).AWG & "AWG"
    End Select
    pkgDESC = pkgDESC & " Cable"
 End Select
Print #1, "CABLE/HOSE: " & pkgDESC
Print #1,

Select Case metricDEFAULT
  Case True:  ftORm = " m"
              lbsORkg = " kg"
              ftmsec = " m/sec"
              ftm2sec = " m2/sec"
              tempunit = " deg C"
  Case False: ftORm = " ft"
              lbsORkg = " lb"
              ftmsec = " ft/sec"
              ftm2sec = " ft2/sec"
              tempunit = " deg F"
End Select


Print #1, "APPLICATION: "
Print #1, "-----------------------------"
Print #1, "Application: " & reelAPPLICATION
  Select Case Left(reelAPPLICATION, 1)
    Case "L", "M": Print #1, "PendantWgt: " & Str(pendantWEIGHT) & lbsORkg
    Case "S": Print #1, "SAG: " & percentSAGstr & " %"
    Case "R", "H": Print #1, "CenterlineHgt: " & Str(centerlineHEIGHT) & ftORm
  End Select
Print #1, "Travel: " & Str(activeTRAVEL) & ftORm
Print #1, "Speed: " & Str(systemSPEED) & ftmsec
Print #1, "Accel: " & Str(systemACCEL) & ftm2sec
Print #1, "TempMin: " & Str(ambTEMPmin) & tempunit
Print #1, "TempMax: " & Str(ambTEMPmax) & tempunit
Print #1, "Dead Wraps: " & Str(deadWRAPS)
Print #1, "Spring Turns %: " & TURNSusedPERCENTstr
Select Case CableCF
  Case "0":  Print #1, "Cable Clearance Factor: Standard"
  Case Else: Print #1, "Cable Clearance Factor: " & Str(CableCF)
End Select
Print #1, "************************************************************"
Print #1,
Print #1, "THE FOLLOWING MODELS WERE FOUND FOR THIS APPLICATION:"
Print #1,
End Sub

Public Sub writeDETAILSsummary()
Dim maxFULLLAYERSfromTORQUEliftI As Integer
Dim extraWRAPSafterFULLLAYERStorqueLIFTi As Integer
Dim maxFULLLAYERSfromTORQUEstretchI As Integer
Dim extraWRAPSafterFULLLAYERStorqueSTRETCHi As Integer
Dim driveTYPE As String
Dim IYIND As Integer
Dim total As Single, clearance As Single


Print #1, "***********************************************************"
Print #1, "Reel Model: " & modelNO
Print #1, "REEL price: " & Format(reelTOTALlistPrice, "$0.00")
Print #1,
Print #1, "Dimensions (inches): " & dimensWIDTH & " W x " & dimensHEIGHT & " H x " & dimensDEPTH & "         Weight: " & modelWEIGHT
Print #1,

Select Case Left(reelAPPLICATION, 1)
  Case "L", "M":  Call writeLIFTsummary
  Case "R": Call writeRETRIEVEsummary
  Case "S": Call writeSTRETCHsummary
End Select

If srchSTYLE = "C" Or srchSTYLE = "HM" Then  'displays different output than other reels
  Print #1,
  Print #1, "Cable Clearance Factor: "; cableCLEARANCEfactor; "   Dead Wraps: " + Str$(deadWRAPS)
  Print #1, "Cable compartment: "; maxUSABLEwrapsR; " wraps, "; compartmentACTIVEcableLENGTH; " feet max"
  Print #1, "Spring turns: "; springTURNSavailAFTERpretensionR; " wraps, "; turnsACTIVEcableLENGTH; " feet max"
  Select Case Left(reelAPPLICATION, 1)
    Case "L", "M":  Print #1, "Spring torque: "; maxWRAPSfromTORQUElift; " wraps, "; maxLENGTHcableFROMtorqueLIFT; " feet max"
    Case "S": Print #1, "Spring torque: "; maxWRAPSfromTORQUEstretch; " wraps, "; maxLENGTHcableFROMtorqueSTRETCH; " feet max"
    Case "R": Print #1, "Max retrieve height: "; maxCENTERLINEheight; " feet"
  End Select
  Print #1,
  Print #1, "Row   Wrap", "Per Wrap", "Per Row", "Total", "Clearance"
  Print #1, "---   ----", "--------", "-------", "-----", "---------"
  total = 0
  If EC <> 0 And cableCLEARANCEfactor >= 1 Then
    IXARR(maxUSABLElayersR) = EC
    Row(maxUSABLElayersR) = IXARR(maxUSABLElayersR) * WRAP(maxUSABLElayersR)
  End If
  For IYIND = 1 To maxUSABLElayersR
    clearance = ((frameSIZE - drumSIZE) / 2) - (IYIND * cableTHICK(1))
    total = Row(IYIND) + total
    Print #1, Str(IYIND) & "   " & Str(IXARR(IYIND)), Format(WRAP(IYIND), "0.00"), Format(Row(IYIND), "0.00"), Format(total, "0.00"), Format(clearance, "0.00")
  Next IYIND
  Exit Sub
End If


Print #1, "Compartment size is "; wrapperWIDTHr; " wide by "; compartmentHEIGHT; " high"
Print #1, "Maximum cable stacking is "; maxWRAPSperLAYERrSTORED; " wide by "; maxCABLElayersR; " high"
Print #1, "Maximum length of cable that will fit in compartment (ft) = "; compartmentMAXIMUMcableLENGTH
Print #1, "Recommended factor of safety (cable diameters) = "; cableCLEARANCEfactor
Print #1, "Recommended cable stacking is "; maxWRAPSperLAYERi; " wide by "; maxUSABLElayersI; " high"
If (srchSPOOLMETHOD = "R" And (srchSTYLE = "SHO" Or srchSTYLE = "TMR")) Or srchSTYLE = "U" Then
  Print #1, "**** Calculations based alternating rows of "; maxWRAPSperLAYERi; " and "; maxWRAPSperLAYERi - 1; " wraps."
End If
Print #1, "Length of cable lost due to 1st clearance wrap (ft) = "; cableCAPACITYlostFIRSTclearanceWRAP
Print #1, "Length of cable lost due to 2nd clearance wrap (ft) = "; cableCAPACITYlostSECONDclearanceWRAP
Print #1, "Length of cable lost due to 3rd clearance wrap (ft) = "; cableCAPACITYlostTHIRDclearanceWRAP
Print #1, "Recommended length of cable to be placed in the compartment (ft) = "; compartmentCABLEcapacity
Print #1, "Length of cable lost due to" + Str$(deadWRAPS) + " dead wrap(s) = "; deadWRAPlength
Print #1, "Maximum length of active cable handled by compartment (ft) = "; compartmentACTIVEcableLENGTH

Print #1, "Cable clearance with safety margin (inches) = "; cableCLEARANCEinINCHES
Print #1, "Cable clearance without 1st wrap of safety margin (inches) = "; cableCLEARANCEinINCHESless1layer
Print #1, "Cable clearance without 2nd wrap of safety margin (inches) = "; cableCLEARANCEinINCHESless2layers
Print #1, "Cable clearance without 3rd wrap of safety margin (inches) = "; cableCLEARANCEinINCHESless3layers
Print #1, "Cable compartment limit summary:"
Print #1, "   maximum cable stacking is "; maxUSABLElayersI; " rows of "; maxWRAPSperLAYERi
If srchSPOOLMETHOD = "R" And (srchSTYLE = "SHO" Or srchSTYLE = "TMR") Then
  Print #1, "**** Calculations based alternating rows of "; maxWRAPSperLAYERi; " and "; maxWRAPSperLAYERi - 1; " wraps."
End If
Print #1, "   maximum length of cable (ft) = "; compartmentMAXIMUMcableLENGTH
Print #1, "   maximum active length of cable (ft) = "; compartmentACTIVEcableLENGTH

If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then  'skip this section for TMR reels
  driveTYPE = "Spring"
  Print #1, "Spring turns limit summary:"
  Print #1, "   maximum cable stacking is "; maxFULLLAYERSfromTURNSi; " rows of "; maxWRAPSperLAYERi; " and 1 row of "; extraWRAPSafterFULLLAYERSturnsi
  Print #1, "   maximum length of cable (ft) = "; turnsMAXIMUMcableLENGTH
  Print #1, "   maximum active length of cable (ft) = "; turnsACTIVEcableLENGTH
Else
  driveTYPE = "Motor"
End If

Select Case Left(reelAPPLICATION, 1)
  Case "L", "M":
    maxFULLLAYERSfromTORQUEliftI = Int(maxFULLLAYERSfromTORQUEliftR)
    extraWRAPSafterFULLLAYERStorqueLIFTi = Int(extraWRAPSafterFULLLAYERStorqueLIFTr)

    Print #1, driveTYPE & " torque limit (on lift) summary:"
    Print #1, "   maximum lift length (ft) = "; torqueACTIVEliftLENGTH
    Print #1, "   maximum cable stacking is "; maxFULLLAYERSfromTORQUEliftI; " rows of "; maxWRAPSperLAYERi; " and 1 row of "; extraWRAPSafterFULLLAYERStorqueLIFTi
    Print #1, "   maximum length of cable (ft) = "; maxLENGTHcableFROMtorqueLIFT
    Print #1, "   maximum active length of cable (ft) = "; maxACTIVElengthOFcableFROMtorqueLIFT
 Case "S":
    maxFULLLAYERSfromTORQUEstretchI = Int(maxFULLLAYERSfromTORQUEstretchR)
    extraWRAPSafterFULLLAYERStorqueSTRETCHi = Int(extraWRAPSafterFULLLAYERStorqueSTRETCHr)
    Print #1, driveTYPE & " torque limit (on stretch) summary:"
    Print #1, "   maximum stretch length (ft) ="; torqueACTIVEstretchLENGTH
    Print #1, "   maximum cable stacking is "; maxFULLLAYERSfromTORQUEstretchI; " rows of "; maxWRAPSperLAYERi; " and 1 row of "; extraWRAPSafterFULLLAYERStorqueSTRETCHi
    Print #1, "   maximum length of cable (ft) = "; maxLENGTHcableFROMtorqueSTRETCH
    Print #1, "   maximum active length of cable (ft) = "; maxACTIVElengthOFcableFROMtorqueSTRETCH

  Case "R":
    Print #1, driveTYPE & " torque limit (on retrieve) summary:"
    Print #1, "   maximum lift height (ft) = "; maxCENTERLINEheight
End Select

Print #1, "Cable required for hook-up/safety wraps(s): " & extraCABLEatREEL; " feet"
Print #1,
Print #1,
End Sub

Public Sub writeLIFTsummary()
' *************************************************************************
' *  Subprogram...: DISPLAY.LIFT. SUMMARY
' *  Description..: Displays lift summary
' *************************************************************************

Print #1, "***** Lift Analysis Summary *****"

If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then
  Print #1, "Turns limit = "; availSPRINGturns
  If specificINPUT(modelINDEX) = True Then
    Print #1, "Unused turns = "; unusedSPRINGturnsFORlift & "      Avail. turns = "; availableSPRINGturnsFORlift
    If unusedSPRINGturnsFORlift <> 0 Or availableSPRINGturnsFORlift <> 0 Then
      Print #1, "Add another pretension turn!"
    End If
  End If
  Print #1, "Net torque with reel full = "; netTORQUEwithREELfullLIFT
End If


Print #1, "Compartment capacity   = "; compartmentACTIVEcableLENGTH

If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then
  Print #1, "Spring turns capacity  = "; turnsACTIVEcableLENGTH
  Print #1, "Spring torque capacity = "; maxACTIVElengthOFcableFROMtorqueLIFT
Else
  Print #1, "Motor torque capacity = "; maxACTIVElengthOFcableFROMtorqueLIFT
End If


Select Case srchSTYLE
  Case "SHO", "TMR":
    If maxLIFTcapacityOFreel < travelINft Or netTORQUEwithREELfullLIFT < 0 Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
      Print #1, "The maximum lift capacity of this reel = ***.*"
    Else
      Print #1, "The maximum lift capacity of this reel = "; maxLIFTcapacityOFreel
    End If
    Print #1, "Shaft stress = " + Format(shaftSTRESS, "0.00") + " PSI (8000 PSI max)"
    Print #1, "Bearing load = " + Format(bearingLOAD, "0.00") + " lbs (2300 lbs max)"
    If srchSTYLE = "TMR" Then
      Print #1, "Max rpm (empty) = " + Format(RNME, "0.00") + " (450 rpm max)"
      Print #1, "Motor torque (empty) = " + Format(TQOUTE, "0.00")
    End If
  Case Else
    Print #1, "The maximum lift capacity of this reel = "; maxLIFTcapacityOFreel
End Select


If maxLIFTcapacityOFreel < travelINft Or netTORQUEwithREELfullLIFT < 0 Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
  Print #1, "* WARNING - the specified reel does not meet the application requirements *"
End If




End Sub

Public Sub writeRETRIEVEsummary()
' *************************************************************************
' *  Subprogram...: DISPLAY.RETRIEVE. SUMMARY
' *  Description..: Displays retrieve summary
' *************************************************************************

Print #1, "***** Retrieve Analysis Summary *****"

Print #1, "Turns limit = "; availSPRINGturns
Print #1, "Maximum lift height = "; maxCENTERLINEheight

Print #1, "Compartment capacity = "; compartmentACTIVEcableLENGTH
If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then
  Print #1, "Spring turns capacity = "; turnsACTIVEcableLENGTH
End If

Select Case srchSTYLE
  Case "SHO", "TMR":
    If maximumRETRIEVEcapacityOFreel < travelINft Or maxCENTERLINEheight < centerlineINft Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
      Print #1, "The maximum retrieve capacity of this reel = ***.**"
    Else
      Print #1, "The maximum retrieve capacity of this reel = "; maximumRETRIEVEcapacityOFreel
    End If
    Print #1, "Shaft stress = " + Format(shaftSTRESS, "0.00") + " PSI (8000 PSI max)"
    Print #1, "Bearing load = " + Format(bearingLOAD, "0.00") + " lbs (2300 lbs max)"
    If srchSTYLE = "TMR" Then
      Print #1, "Max lift hgt (empty) = " + Format(RETE, "0.00") + "    max lift hgt (full) = " + Format(RETF, "0.00")
      Print #1, "Max rpm (empty) = " + Format(RNME, "0.00") + "        max rpm (full) = " + Format(RNMF, "0.00")
      Print #1, "Motor torque (empty) = " + Format(TQOUTE, "0.00") + "    motor torque (full) = " + Format(TQOUTF, "0.00")
    End If
  Case Else
    Print #1, "The maximum retrieve capacity of this reel = "; maximumRETRIEVEcapacityOFreel
End Select


If maximumRETRIEVEcapacityOFreel < travelINft Or maxCENTERLINEheight < centerlineINft Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
  Print #1, "* WARNING - the specified reel does not meet the application requirements *"
End If


End Sub

Public Sub writeSTRETCHsummary()
' *************************************************************************
' *  Subprogram...: DISPLAY.STRETCH. SUMMARY
' *  Description..: Displays stretch summary
' *************************************************************************

Print #1, "***** Stretch Analysis Summary *****"


If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then
  Print #1, "Turns limit = "; availSPRINGturns
  If specificINPUT(modelINDEX) = True Then
    Print #1, "Unused turns = "; unusedSPRINGturnsFORstretch, "   avail. turns = "; availableSPRINGturnsFORstretch
    If unusedSPRINGturnsFORstretch <> 0 Or availableSPRINGturnsFORstretch <> 0 Then
      Print #1, "Add another pretension turn!"
    End If
  End If
  Print #1, "Net torque with reel full = "; netTORQUEwithREELfullSTRETCH
End If

Print #1, "Compartment capacity   = "; compartmentACTIVEcableLENGTH

If srchSTYLE = "SHO" Then
  Print #1, "Spring turns capacity  = "; turnsACTIVEcableLENGTH
  Print #1, "Spring torque capacity = "; maxACTIVElengthOFcableFROMtorqueSTRETCH
Else
  Print #1, "Motor torque capacity = "; maxACTIVElengthOFcableFROMtorqueSTRETCH
End If


If maxSTRETCHcapacityOFreel < travelINft Or netTORQUEwithREELfullSTRETCH < 0 Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
  Print #1, "The maximum stretch capacity of this reel = ***.**"
Else
  Print #1, "The maximum stretch capacity of this reel = "; maxSTRETCHcapacityOFreel
End If

If srchSTYLE = "SHO" Or srchSTYLE = "TMR" Then
  Print #1, "Shaft stress = " + Format(shaftSTRESS, "0.00") + "  PSI (8000 PSI max)"
  Print #1, "Bearing load = " + Format(bearingLOAD, "0.00") + "  lbs (2300 lbs max)"
  If srchSTYLE = "TMR" Then
    Print #1, "Max rpm (empty)= " + Format(RNME, "0.00") + " (450 rpm max)"
    Print #1, "Motor torque (empty) = " + Format(TQOUTE, "0.00")
  End If
End If


If maxSTRETCHcapacityOFreel < travelINft Or netTORQUEwithREELfullSTRETCH < 0 Or shaftSTRESS > 8000 Or bearingLOAD > 2300 Or RNME > 450 Then
  Print #1, "* Warning - the specified reel does not meet the application requirements *"
End If

End Sub

Public Sub calcSHAFTstress()
Dim FAC As Single
Dim STBND As Single
Dim STTOR As Single



FAC = 1! / (1! - (SID / SOD) ^ 4!)

'MsgBox FAC
STTOR = (5.1 * adjustedTORQUE * 12! / SOD ^ 3) * FAC
'MsgBox STTOR
'MsgBox adjustedTORQUE
STBND = (10 * RMOM * SOD) / (SOD ^ 4! - SID ^ 4)
'MsgBox RMOM
'MsgBox STBND
shaftSTRESS = Sqr(STBND ^ 2 + 3 * STTOR ^ 2)
'MsgBox shaftSTRESS
End Sub

Public Sub calcSTRESSbearing()
Dim X1DIST As Single, YDIST As Single, XDIST As Single
Dim totalCABLEweight As Single, totalWEIGHT As Single
validSTRESS = False

If srchSPOOLMETHOD = "R" And frameSIZE < 54 Then X1DIST = 3.94 + 0.1197
If srchSPOOLMETHOD = "R" And frameSIZE = 54 Then X1DIST = 3.94 + 1!
If srchSPOOLMETHOD = "M" Then X1DIST = 3.94 + 1!
YDIST = 8.75
XDIST = X1DIST + wrapperWIDTHr / 2
'MsgBox XDIST
'MsgBox Left(reelAPPLICATION, 1)
'MsgBox maxLIFTcapacityOFreel
'MsgBox cableWGT(1)
Select Case Left(reelAPPLICATION, 1)
  Case "L", "M": totalCABLEweight = maxLIFTcapacityOFreel * cableWGT(1)
  Case "S": totalCABLEweight = maxSTRETCHcapacityOFreel * cableWGT(1)
  Case "R": totalCABLEweight = maximumRETRIEVEcapacityOFreel * cableWGT(1)
End Select
'MsgBox totalCABLEweight
totalWEIGHT = totalWEIGHTlessCABLE + totalCABLEweight
'MsgBox totalWEIGHT
RMOM = XDIST * totalWEIGHT

Select Case UCase(srchGEAR)
  Case "AA", "AB", "AC", "AD", "AE", "ALL": SOD = 1.998: SID = 1.5
  Case "BA", "BB", "BC", "BD", "BE": SOD = 2.188: SID = 1.5: 'recCHAIN = "B" + Right(srchGEAR, 1)
End Select

Call calcSHAFTstress

If shaftSTRESS > 8000 And UCase(SHOchainratioSEL) = "ALL" Then
  srchGEAR = "B" + Right(srchGEAR, 1)
  SOD = 2.188
  SID = 1.5
  Call calcSHAFTstress
End If

If shaftSTRESS > 8000 And specificINPUT(modelINDEX) = False Then Exit Sub

bearingLOAD = totalWEIGHT * (XDIST + YDIST) / YDIST
If bearingLOAD > 2300 And specificINPUT(modelINDEX) = False Then Exit Sub
validSTRESS = True
If shaftSTRESS > 8000 Or bearingLOAD > 2300 Then invalidWARNING = True

End Sub

Public Sub getHOSEfittings()
'hose clamps required for all UH and HM reels
  Select Case hoseIDcode  '2013 prices
    Case "4": malepipePN = "GR625241": malepipePRICE = 2.8
              hoseferrulePN = "GR029073": hoseclampPN = "GR101478" 'use ferrules
    Case "6": malepipePN = "GR625233": malepipePRICE = 3.55
              hoseferrulePN = "GR029074": hoseclampPN = "GR101479" 'use ferrules
    Case "8": malepipePN = "GR101539": malepipePRICE = 5.8
              hoseferrulePN = "GR029075": hoseclampPN = "GR101480" 'use ferrules
    Case "12": malepipePN = "GR101540": malepipePRICE = 9.15
             hoseferrulePN = "": hoseclampPN = "GR101481"
    Case "16": malepipePN = "GR101541": malepipePRICE = 23.7
              hoseferrulePN = "": hoseclampPN = "GR101482"
    Case "20": malepipePN = "GR101535": malepipePRICE = 46.7
              hoseferrulePN = "": hoseclampPN = "GR107705"
    Case "24": malepipePN = "GR101536": malepipePRICE = 54.6
               hoseferrulePN = "": hoseclampPN = "GR107705"
   End Select
   hoseclampPRICE = 4.15  'SAME FOR ALL SIZES  '2013 pricing
   hoseferrulePRICE = 4.3   'SAME FOR ALL SIZES
End Sub

Public Sub calcUreelWIDTH()
 Select Case cableORhose
      Case "HD", "HS":  'hoses
        Select Case hoseIDcode
         Case "4": UreelWIDTH = 6: UreelWIDTHinp = "06"  '**
         Case "6": UreelWIDTH = 6: UreelWIDTHinp = "06"  '**
         Case "8": UreelWIDTH = 6: UreelWIDTHinp = "06"  '**
         Case "12": UreelWIDTH = 8: UreelWIDTHinp = "08"    '**
         Case "16": UreelWIDTH = 8: UreelWIDTHinp = "08"
         Case "20": UreelWIDTH = 10: UreelWIDTHinp = "10"
         Case "24": UreelWIDTH = 10: UreelWIDTHinp = "10"
       End Select
     Case Else:
       Select Case cableTHICK(1)
         Case Is < 1: UreelWIDTH = 7 * cableTHICK(1)
         Case Else: UreelWIDTH = 5 * cableTHICK(1)
       End Select

       If UreelWIDTH <> Int(UreelWIDTH) Then UreelWIDTH = Int(UreelWIDTH + 1) 'round to nearest integer
       If UreelWIDTH / 2 <> Int(UreelWIDTH / 2) Then UreelWIDTH = UreelWIDTH + 1  'round to nearest 2"
       If UreelWIDTH < 6 Then UreelWIDTH = 6

       UreelWIDTHinp = LTrim$(RTrim$(Str$(UreelWIDTH)))
       If Len(UreelWIDTHinp) = 1 Then UreelWIDTHinp = "0" + UreelWIDTHinp
   End Select
End Sub

Public Sub accessPreel()
'2013 prices
If optANDacc(optPNTR).cableGRIPresp Then
     Select Case cableTHICK(1)
       Case Is >= 1.25: cablegripPN = "GR027618": cablegripPRICE = 192
       Case Is >= 1!: cablegripPN = "GR027617": cablegripPRICE = 186
       Case Is >= 0.75: cablegripPN = "GR027616": cablegripPRICE = 145
       Case Is >= 0.53: cablegripPN = "GR027615": cablegripPRICE = 134
       Case Is >= 0.41: cablegripPN = "GR027614": cablegripPRICE = 114
    End Select
  End If
End Sub
