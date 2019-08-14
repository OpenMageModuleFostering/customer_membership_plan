<?php

class Goigi_Sellerplan_Block_Adminhtml_Sellerplan_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sellerplanGrid');
      $this->setDefaultSort('sellerplan_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sellerplan/sellerplan')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sellerplan_id', array(
          'header'    => Mage::helper('sellerplan')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sellerplan_id',
      ));

      $this->addColumn('plan_title', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Name'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'plan_title',
      ));

	 
      $this->addColumn('plan_desc', array(
			'header'    => Mage::helper('sellerplan')->__('Plan Description'),
			
			'index'     => 'plan_desc',
      ));
	  
	  $this->addColumn('plan_price', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Price'),
          'align'     =>'left',
		  'width'     => '100px',
          'index'     => 'plan_price',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('sellerplan')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sellerplan')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sellerplan')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sellerplan')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sellerplan')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sellerplan_id');
        $this->getMassactionBlock()->setFormFieldName('sellerplan');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('sellerplan')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('sellerplan')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('sellerplan/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('sellerplan')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('sellerplan')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}