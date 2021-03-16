<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsonResponseFunction extends Controller{

   
   /*
   * Fetch reponse
   *----------------------------------------------------------------------------
   */
   public static function successResponse($data){
   		return Response()->json([
                        'success' => true,
                        'message' => 'Data is fetched successfully',
                        'data' => $data
                    ], 200);
   }

   public static function errorResponse(){
   		return Response()->json([
                        'success' => false,
                        'message' => 'Data is not fetch successfully',
                        'data' => []
                    ], 500);
   }


   /*
   * Inserted reponse
   *----------------------------------------------------------------------------
   */
   public static function createdSuccessReponse($data){
      return Response()->json([
                        'success' => true,
                        'message' => 'Data is added successfully',
                        'data' => $data
                    ], 200);
   }

   public static function createdErrorReponse(){
      return Response()->json([
                        'success' => false,
                        'message' => 'Data is not added successfully',
                        'data' => []
                    ], 500);
   }


  /*
   * Update reponse
   *----------------------------------------------------------------------------
   */

  public static function successUpdatedResponse($data){
   		return Response()->json([
                        'success' => true,
                        'message' => 'Data is updated successfully',
                        'data' => $data
                    ], 200);
   }

  public static function errorUpdatedResponse($data){
   		return Response()->json([
                        'success' => true,
                        'message' => 'Data is not updated successfully',
                        'data' => $data
                    ], 500);
   }



   /*
   * Delete reponse
   *----------------------------------------------------------------------------
   */
   public static function successDeleteResponse(){
   		return Response()->json([
                        'success' => true,
                        'message' => 'Data is deleted successfully',
                        'status' => 1
                    ], 200);
   }

   public static function errorDeleteResponse(){
   		return Response()->json([
                        'success' => false,
                        'message' => 'Data is not deleted successfully',
                        'status' => 0
                    ], 500);
   }
}
