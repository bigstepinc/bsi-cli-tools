#config.py
import sys
import os.path
sys.path.append(os.path.join(os.path.dirname(__file__), '..'))

from BSI.BSI import BSI
from JSONRPC.filters.client.SignatureAdd import JSONRPC_filter_signature_add
from JSONRPC.filters.client.DebugLogger import DebugLogger
from BSI.BSIFilter import BSIFilter
import json


class Config(object):

        strBSIEndpointURL=""
        strBSIAPIKey=""
        nBSIUserID = 0
        nBSIBillableUserID = 0
	bsi=0


        def __init__(self, bDisableValidation = False):

		self.strBSIEndpointURL=os.environ.get("BSI_ENDPOINT_URL")
		self.strBSIAPIKey=os.environ.get("BSI_API_KEY")

		self.nBSIUserID=self.nBSIBillableUserID=self.strBSIAPIKey.split(':')[0]

                if bDisableValidation != False:
                        validation()

		self.bsi=BSI.getInstance(self.strBSIEndpointURL) 
		"""
		* Adding BSI authentication plugin to JSON-RPC client.
		"""
		self.bsi.addFilterPlugin(
			JSONRPC_filter_signature_add(
				self.strBSIAPIKey,
				{
				}
			)
		)





        def validation():

                if self.nBSIUserID == 0:
                        raise Exception("nBSIUserID variable not set in example_config.py")

                if self.nBSIBillableUserID == 0:
                        raise Exception("nBSIBillableUserID variable not set in example_config.py")

                if len(self.strBSIEndpointURL) == 0:
                        raise Exception("strBSIEndpointURL variable not set in example_config.py")

                if len(self.strBSIAPIKey) == 0:
                        raise Exception("strBSIAPIKey variable not set in example_config.py")
	def bsi():
		return bsi

	def ensureRequired(self,parser,options):

		defaults = vars(parser.get_default_values())
		optionsdict = vars(options)

		all_none = False        
		for k,v in optionsdict.items():
			if v is None and defaults.get(k) is None:
			    all_none = True
			    print k

		if all_none:
			parser.print_help()
			sys.exit()
	
	def print_deploy_warning(self):
		print "\x1B[32mDon't forget to run infrastructure_deploy to actually propagate the changes.\x1B[m"




