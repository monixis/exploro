<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" />

    <xsl:template match="/">
      <add>
          <xsl:apply-templates select="ead"/>
      </add>
     </xsl:template>
    <xsl:template match="ead">

      <xsl:variable name="collection" select="control/filedesc/titlestmt/titleproper"/>
      <xsl:variable name="genreform" select="archdesc/controlaccess/genreform/part"/>
  		<xsl:variable name="myUnitID" select="archdesc/did/unitid"/>

  		<!-- Getting the folder name for the unittitle, ex LTP -->
  		<xsl:variable name="folderName" select="../collectionFolder"/>
      <xsl:variable name="container" select="archdesc/dsc/c01/c02/c03/c04/c05/c06/c07/did/container"/>

  		<!-- Used to get collection name ex: Lowell Thomas Papers -->
  		<xsl:variable name="myCollection" select="archdesc/dsc/c01/did/unittitle"/>

  		<!-- Links to the finding aids -->
  		<xsl:variable name="collectionLink">http://library.marist.edu/exploro/?c=exploro<![CDATA[&]]>m=viewEAD<![CDATA[&]]>cid=<xsl:value-of select="$folderName"/><![CDATA[&]]>id=<xsl:value-of select="$myUnitID"/></xsl:variable>
          <!-- doc1 is named different so it is not included in the foreach in the dataimporter... it contains information about the colleciton as a whole, not an indiviudal record -->
          <doc1>
    				<field name="collectionLink">
    					<xsl:value-of select="$collectionLink"/>
    				</field>

            <xsl:if test="control/filedesc/publicationstmt/publisher">
                    <field name="publisher">
                        <xsl:value-of select="control/filedesc/publicationstmt/publisher"/>
                    </field>
            </xsl:if>
            <xsl:if test="control/filedesc/publicationstmt/date">
                     <field name="publisheddate">
                         <xsl:value-of select="control/filedesc/publicationstmt/date"/>
                     </field>
            </xsl:if>
            <xsl:if test="control/filedesc/publicationstmt/address/addressline">
                     <field name="publisheraddress">
                         <xsl:value-of select="control/filedesc/publicationstmt/address/addressline"/>
                     </field>
            </xsl:if>
            <xsl:if test="archdesc/did/repository/corpname">
                     <field name="corpname">
                          <xsl:value-of select="archdesc/did/repository/corpname"/>
                     </field>
            </xsl:if>
            <xsl:if test="archdesc/did/repository/corpname/address/addressline">
                <field name="corpaddress">
                    <xsl:value-of select="archdesc/did/repository/corpname/address/addressline"/>
                </field>
            </xsl:if>
            <xsl:if test="archdesc/did/repository/corpname/@identifier">
                     <field name="corplink">
                         <xsl:value-of select="archdesc/did/repository/corpname/@identifier"/>
                     </field>
            </xsl:if>
            <xsl:if test="archdesc/did/origination/@identifier">
                <field name="originLink">
                    <xsl:value-of select="archdesc/did/origination/@identifier"/>
                </field>
            </xsl:if>
            <xsl:if test="archdesc/did/origination/persname">
                <field name="origination">
                    <xsl:value-of select="archdesc/did/origination/persname/part"/>
                </field>
            </xsl:if>
            <xsl:if test="archdesc/did/unitdatestructured/daterange/datesingle">
                     <field name="datesingle">
                         <xsl:value-of select="archdesc/did/unitdatestructured/daterange/datesingle"/>
                     </field>
            </xsl:if>
            <xsl:if test="archdesc/did/unitdatestructured/daterange/fromdate">
                     <field name="fromdate">
                         <xsl:value-of select="archdesc/did/unitdatestructured/daterange/fromdate"/>
                     </field>
            </xsl:if>
            <xsl:if test="archdesc/did/unitdatestructured/daterange/todate">
                    <field name="todate">
                        <xsl:value-of select="archdesc/did/unitdatestructured/daterange/todate"/>
                    </field>
            </xsl:if>
            <xsl:if test="archdesc/did/physdescstructured/@physdescstructuredtype">
                <field name='physdesc'>
                    <xsl:value-of select="archdesc/did/physdescstructured/quantity"/>(<xsl:value-of select="archdesc/did/physdescstructured/unittype"/>)
                </field>
            </xsl:if>

            <xsl:if test="archdesc/did/unitid">
                <field name="unitid">
                    <xsl:value-of select="concat($folderName, '.', $myUnitID)"/>
                </field>
            </xsl:if>
  				<field name="collection">
  					<xsl:value-of select="$myCollection"/>
  				</field>
          <xsl:if test="archdesc/accessrestrict">
              <field name="accessrestrict">
                  <xsl:value-of select="archdesc/accessrestrict"/>
              </field>
          </xsl:if>
          <xsl:if test="archdesc/userrestrict">
              <field name="userrestrict">
                  <xsl:value-of select="archdesc/userrestrict"/>
              </field>
          </xsl:if>
          <xsl:if test="archdesc/controlaccess/genreform">
              <field name="genreform">
                  <xsl:value-of select="archdesc/controlaccess/genreform/part"/>
              </field>
          </xsl:if>
          <xsl:if test="archdesc/controlaccess/geogname">
            <field name="geogname">
                <xsl:value-of select="archdesc/controlaccess/geogname/part"/>
            </field>
            <field name="geogLink">
              <xsl:value-of select="archdesc/controlaccess/geogname/@identifier"/>
            </field>
          </xsl:if>
        </doc1>

        <!-- Parses the indiviudal records  -->
        <xsl:for-each select=".//*[@level='recordgrp']">
          <xsl:variable name="itemContainer" select="./did/container"/>
          <xsl:for-each select=".//*[@level='item']">
					  <xsl:variable name="itemUnitID" select="did/unitid"/>
            <doc>
  						<field name="collectionLink">
  						  <xsl:value-of select="$collectionLink"/>
  						</field>

              <xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyz'" />
              <xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'" />

              <field name="collection">
                  <xsl:value-of select="normalize-space($myCollection)" />
              </field>

              <xsl:variable name="itemGenreForm" select="./controlaccess/genreform/part"/>
              <field name="format">
                <xsl:choose>
                <xsl:when test="concat($genreform, $itemGenreForm)">
                  <xsl:if test="$genreform"><xsl:value-of select="translate($genreform, $uppercase, $lowercase)" /></xsl:if> <xsl:if test="./controlaccess/genreform/part"> <xsl:choose><xsl:when test="$genreform"><xsl:value-of select="concat(', ', $itemGenreForm)"/></xsl:when><xsl:otherwise><xsl:value-of select="$itemGenreForm"/></xsl:otherwise></xsl:choose> </xsl:if>
                </xsl:when>
                <xsl:otherwise>N/A</xsl:otherwise>
              </xsl:choose>
              </field>

              <!-- Unit ID is collectionFolderName.Container.ItemUnitID ... this will uniquely identify the record within SOLR -->
              <field name="unitid">
                  <xsl:value-of select="concat($folderName, '.', $itemContainer, '.', $itemUnitID)"/>
              </field>
              <field name="unittitle">
                  <xsl:value-of select="./did/unittitle"/>
              </field>
              <!-- Variables required to make all characters in dates lowercase to fight inconsitent data -->
              <xsl:variable name="datesingle" select="did/unitdatestructured/datesingle"/>

              <xsl:if test="./did/unitdatestructured/datesingle">
                  <field name="datesingle">
                      <xsl:value-of select="translate(string($datesingle), $uppercase, $lowercase)"/>
                  </field>
              </xsl:if>
              <xsl:if test="./did/unitdatestructured/daterange/fromdate">
                  <field name="datesingle">
                      <xsl:value-of select="./did/unitdatestructured/daterange/fromdate"/>-<xsl:value-of select="./did/unitdatestructured/daterange/todate"/>
                  </field>
              </xsl:if>
              <xsl:if test="./physdescstructured/dimensions">
                <field name="physdesc">
                    <xsl:value-of select="./physdescstructured/dimensions"/>
                </field>
              </xsl:if>

              <field name="container">
                <xsl:value-of select="../container"/>
              </field>

						<!-- taken from https://stackoverflow.com/questions/13622338/how-to-implement-if-else-statement-in-xslt This handles the category of the record.. if there is no digitial file it assigns default photo -->
						<xsl:choose>
							<xsl:when test="./dao">
								<field name="link">
									<xsl:value-of select="./dao/@href"/>
								</field>
								<field name="category">
									<xsl:value-of select="'Digitized'"/>
								</field>
							</xsl:when>
							<xsl:otherwise>
								<field name="link">
									<xsl:value-of select="'http://148.100.181.189:8090/testing/images/folder-icon.png'"/>
								</field>
								<field name="category">
									<xsl:value-of select="'Non-Digitized'"/>
								</field>
							</xsl:otherwise>
						</xsl:choose>

            <xsl:if test="./userestrict">
              <field name="userestrict">
                <xsl:value-of select="./userestrict"/>
              </field>
            </xsl:if>
          </doc>

        </xsl:for-each>
      </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
