<?php
class Expense_staff_daily_entry_model extends CI_Model{
    public function Initial_data($ErrorMessage)
    {
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID IN (26,23)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('DISTINCT CONCAT(ED.EMP_FIRST_NAME," ",ED.EMP_LAST_NAME) AS EMPLOYEE_NAME,ED.EMP_ID,EDSS.EDSS_ID,EDSS.EDSS_CPF_NUMBER,EDSS.EDSS_LEVY_AMOUNT,EDSS.EDSS_SALARY_AMOUNT,EDSS.EDSS_CPF_AMOUNT',FALSE);
        $this->db->from('EMPLOYEE_DETAILS ED,EXPENSE_DETAIL_STAFF_SALARY EDSS');
        $this->db->where('ED.EMP_ID=EDSS.EMP_ID');
        $query = $this->db->get();
        $result2 = $query->result();

        $this->db->select('EMP_ID');
        $this->db->from('EMPLOYEE_DETAILS');
        $query = $this->db->get();
        $result3 = $query->result();

        return $result[]=array($result1,$result2,$result3,$ErrorMessage);
    }
}