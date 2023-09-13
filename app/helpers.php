<?php
    function hasPermission($id,$objective) {// برای چک کردان سطح دسترسی ادمین ها استفاده می شود.
        $hasAcess=DB::select("SELECT $objective from NewStarfood.dbo.star_hasAccess1 where adminId=".$id)[0]->$objective;
        return $hasAcess;
    }
	function showEnamad($enamadPage) { // (   پارامتر خانه و صفحات دیگر قیمت میگیرد )برای نمایش اینماد در صفحات خانه  و یا بقیه صفحات استفاده می شود.
        $enamadState=DB::select("SELECT $enamadPage from NewStarfood.dbo.star_webSpecialSetting")[0]->$enamadPage;
        return $enamadState;
    }
	function canUseCheque($customerId){ // بررسی می کند که آیا طرف حق استفاده از خرید چکی را دارد یا خیر
		$canUseCheque=0;
		$chequeReqStates=DB::select("SELECT AcceptState FROM NewStarfood.dbo.star_checkRequest WHERE CustomerId=$customerId");
		if(count($chequeReqStates)>0){
			if($chequeReqStates[0]->AcceptState =="Accepted"){
				$canUseCheque=1;
			}
		}
		return $canUseCheque;
	}
// تعداد پیامهای را که جدیدا از سمت مشتری به پشتیبانی سایت آمده اند بر میگرداند.
	function hasNewMessage($adminId){
		$countNewMessage=0;// تعداد پیامهای جدید آمده
		$newMessages=DB::select("SELECT COUNT(id) AS countMessage FROM NewStarfood.dbo.star_message
								WHERE readState=0");
		if(count($newMessages)>0){
			$countNewMessage=$newMessages[0]->countMessage;
		}
		return $countNewMessage;
	}

	function hasNewNazar($adminId){ // افرادی را که جدیدا نظر سنجی اند بر می گردانند.
		$countNewNazar=0;
		$newNazars=DB::select("SELECT COUNT(id) AS countAnswer FROM NewStarfood.dbo.star_answers
								WHERE isSeen=0");
		if(count($newNazars)>0){
			$countNewNazar=$newNazars[0]->countAnswer;
		}
		return $countNewNazar;
	}

	function usedTakhfifCode($adminId){ // تعداد افرادی را که جدیدا از کد تخفیف استفاده کرده اند بر می گردانند.
		$countNewTakhfifCode=0;
		$newCodes=DB::select("SELECT COUNT(CodeAssingSn)countUsedCode FROM NewStarfood.dbo.star_takhfifCodeAssign  WHERE IsUsed=1 AND isSeen=0");
		if(count($newCodes)>0){
			$countNewTakhfifCode=$newCodes[0]->countUsedCode;
		}
		return $countNewTakhfifCode;
	}

	function usedTakhfifCase($adminId){// تعداد افرادی را که جدیدا از کیف پول استفاده کرده اند بر می گردانند.
		$countNewCase=0;
		$newCases=DB::select("SELECT COUNT(id)countUsedCase FROM NewStarfood.dbo.star_takhfifHistory  WHERE isUsed=1 AND isSeen=0");
		if(count($newCases)>0){
			$countNewCase=$newCases[0]->countUsedCase;
		}
		return $countNewCase;
	}
	
	function playedGame($adminId){// بازی های را که جدیدا بازی شده است حساب می کند.
		$countNewGame=0;
		$newPlayedGames=DB::select("SELECT COUNT(id)countPlayedGame FROM NewStarfood.dbo.star_game_history where deleted=0");
		if(count($newPlayedGames)>0){
			$countNewGame=$newPlayedGames[0]->countPlayedGame;
		}
		return $countNewGame;
	}

	function wonLottery($adminId){// تعداد لاتاری هایی که جدیدا برنده شده اند را برمی گرداند.
		$countNewLottery=0;
		$newLotteries=DB::select("SELECT COUNT(id)countTryLottery FROM NewStarfood.dbo.star_TryLottery  WHERE Istaken=0");
		if(count($newLotteries)>0){
			$countNewLottery=$newLotteries[0]->countTryLottery;
		}
		return $countNewLottery;
	}


?>